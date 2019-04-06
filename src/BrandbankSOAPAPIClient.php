<?php

namespace BrandbankSOAPAPIClient;

use Artisaninweb\SoapWrapper\Client;
use Artisaninweb\SoapWrapper\Exceptions\ServiceAlreadyExists;
use Artisaninweb\SoapWrapper\SoapWrapper;
use BrandbankSOAPAPIClient\Exception\BrandbankSOAPException;
use BrandbankSOAPAPIClient\Interfaces\AuthenticatorInterface;
use BrandbankSOAPAPIClient\Interfaces\RequestInterface;
use BrandbankSOAPAPIClient\Interfaces\ResponseInterface;
use BrandbankSOAPAPIClient\Request\AcknowledgeMessageRequest;
use BrandbankSOAPAPIClient\Request\GetUnsentProductDataRequest;
use BrandbankSOAPAPIClient\Request\SupplyCoverageReport\AcknowledgeMessage;
use BrandbankSOAPAPIClient\Request\SupplyCoverageReport\RetailerFeedbackReport;
use BrandbankSOAPAPIClient\Request\SupplyCoverageReport\SupplyCoverageReport;
use BrandbankSOAPAPIClient\Request\SupplyCoverageReport\xmlData;
use BrandbankSOAPAPIClient\Request\SupplyCoverageReportRequest;
use BrandbankSOAPAPIClient\Response\AcknowledgeMessageResponse;
use BrandbankSOAPAPIClient\Response\GetUnsentProductDataResponse;
use BrandbankSOAPAPIClient\Response\SupplyCoverageReportResponse;
use BrandbankSOAPAPIClient\Service\AcknowledgeMessageService;
use BrandbankSOAPAPIClient\Service\ReportDataService;
use BrandbankSOAPAPIClient\Service\SupplyCoverageReportService;

class BrandbankSOAPAPIClient
{
    /** @var SoapWrapper */
    private $soapWrapper;
    /** @var string */
    private $lastRequestXml = null;
    /** @var string */
    private $lastResponseXml = null;
    /** @var string */
    private $lastRequestHeaders = null;
    /** @var string */
    private $lastResponseHeaders = null;

    /**
     * @param RetailerFeedbackReport $report
     * @return SupplyCoverageReportResponse
     */
    public function callSupplyCoverageReport(RetailerFeedbackReport $report): SupplyCoverageReportResponse
    {
        // generate request chain
        $request = new SupplyCoverageReportRequest(new SupplyCoverageReport(new xmlData($report)));

        try {
            // call
            $response = $this->call(SupplyCoverageReportService::class, $request);

        } catch (\Throwable $throwable) {
            new BrandbankSOAPException($throwable->getMessage(), $throwable->getCode(), $throwable);
        }

        /** @var $response SupplyCoverageReportResponse */
        return $response;
    }
    
    /**
     * @param string $guid
     * @return AcknowledgeMessageResponse
     */
    public function callAcknowledgeMessage(string $guid): AcknowledgeMessageResponse
    {
        // generate request chain
        $request = new AcknowledgeMessageRequest(new AcknowledgeMessage($guid));
        
        try {
            // call
            $response = $this->call(AcknowledgeMessageService::class, $request);
            
        } catch (\Throwable $throwable) {
            new BrandbankSOAPException($throwable->getMessage(), $throwable->getCode(), $throwable);
        }
        
        /** @var $response AcknowledgeMessageResponse */
        return $response;
    }
    
    /**
     * @return GetUnsentProductDataResponse
     */
    public function callGetUnsentProductData(): GetUnsentProductDataResponse
    {
        // generate request chain
        $request = new GetUnsentProductDataRequest();

        try {
            // call
            $response = $this->call(ReportDataService::class, $request);

        } catch (\Throwable $throwable) {
            new BrandbankSOAPException($throwable->getMessage(), $throwable->getCode(), $throwable);
        }

        /** @var $response GetUnsentProductDataResponse */
        return $response;
    }

    public function getLastRequestXml(): ?string
    {
        return $this->lastRequestXml;
    }

    public function getLastResponseXml(): ?string
    {
        return $this->lastResponseXml;
    }

    public function getLastRequestHeaders(): ?string
    {
        return $this->lastRequestHeaders;
    }

    public function getLastResponseHeaders(): ?string
    {
        return $this->lastResponseHeaders;
    }

    /**
     * Call a method from a registered service
     *
     * @param string $serviceName
     * @param RequestInterface $request
     * @param array $options
     * @return ResponseInterface
     * @throws \Artisaninweb\SoapWrapper\Exceptions\ServiceNotFound
     */
    private function call(string $serviceName, RequestInterface $request, array $options = []): ResponseInterface
    {
        // make needed clean up
        $this->lastRequestXml = null;
        $this->lastResponseXml = null;
        $this->lastRequestHeaders = null;
        $this->lastResponseHeaders = null;

        // call
        $response = $this->soapWrapper->call($serviceName . '.' . $request::getSOAPMethodName(), $request->toArray(), $options);

        // parse result
        $cl = $this->soapWrapper->client($serviceName, function ($c) {
            return $c;
        });
        /** @var Client $cl */
        $this->lastRequestXml = $cl->getLastRequest();
        $this->lastResponseXml = $cl->getLastResponse();
        $this->lastRequestHeaders = $cl->getLastResponse();
        $this->lastResponseHeaders = $cl->getLastResponse();

        return $response;
    }

    /**
     * BrandbankSOAPAPIClient constructor
     *
     * @param AuthenticatorInterface $authenticator
     */
    public function __construct(AuthenticatorInterface $authenticator)
    {
        $this->soapWrapper = new SoapWrapper();

        try {

            // register new service with name SupplyCoverageReportService::class
            $this->soapWrapper->add(
                SupplyCoverageReportService::class,
                \Closure::fromCallable(new SupplyCoverageReportService($authenticator))
            );

            // register new service with name ReportDataService::class
            $this->soapWrapper->add(
                ReportDataService::class,
                \Closure::fromCallable(new ReportDataService($authenticator))
            );
    
            // register new service with name ReportDataService::class
            $this->soapWrapper->add(
                AcknowledgeMessageService::class,
                \Closure::fromCallable(new AcknowledgeMessageService($authenticator))
            );

        } catch (ServiceAlreadyExists $exception) {
            // ignore
        }
    }
}