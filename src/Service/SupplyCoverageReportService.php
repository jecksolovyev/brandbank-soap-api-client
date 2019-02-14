<?php

namespace BrandbankSOAPAPIClient\Service;

use Artisaninweb\SoapWrapper\Service;
use BrandbankSOAPAPIClient\Response\SupplyCoverageReportResponse;

class SupplyCoverageReportService extends AbstractService
{
    private $xml;

    public function setXml($xml): void
    {
        $this->xml = $xml;
    }

    public function __invoke(Service $service): void
    {
        $service
            ->wsdl('https://api.brandbank.com/svc/feed/reportdata.asmx?wsdl')
            ->trace(true)
            ->classMap([
                SupplyCoverageReportResponse::class
            ]);

        $this->getAuthenticator()->authenticate($service);
    }
}