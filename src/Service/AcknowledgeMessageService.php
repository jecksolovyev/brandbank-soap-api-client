<?php

namespace BrandbankSOAPAPIClient\Service;

use Artisaninweb\SoapWrapper\Service;
use BrandbankSOAPAPIClient\Response\AcknowledgeMessageResponse;

class AcknowledgeMessageService extends AbstractService
{
    public function __invoke(Service $service): void
    {
        $service
            ->wsdl('https://api.brandbank.com/svc/feed/extractdata.asmx?wsdl')
            ->trace(true)
            ->classMap([
                AcknowledgeMessageResponse::class
            ]);

        $this->getAuthenticator()->authenticate($service);
    }
}