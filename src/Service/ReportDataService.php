<?php

namespace BrandbankSOAPAPIClient\Service;

use Artisaninweb\SoapWrapper\Service;
use BrandbankSOAPAPIClient\Response\GetUnsentProductDataResponse;
use BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult;

class ReportDataService extends AbstractService
{
    public function __invoke(Service $service): void
    {
        $service
            ->wsdl('https://api.brandbank.com/svc/feed/extractdata.asmx?wsdl')
            ->trace(true)
            ->classMap([
                GetUnsentProductDataResponse::class,
                GetUnsentProductDataResult::class
            ]);

        $this->getAuthenticator()->authenticate($service);
    }
}