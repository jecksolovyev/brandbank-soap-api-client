<?php

namespace BrandbankSOAPAPIClient\Authenticator;

use Artisaninweb\SoapWrapper\Service;
use BrandbankSOAPAPIClient\Interfaces\AuthenticatorInterface;
use SoapHeader;

class HeaderGuidAuthenticator implements AuthenticatorInterface
{
    /** @var string $guid */
    private $guid;

    public function __construct(string $guid)
    {
        $this->guid = $guid;
    }

    public function getGuid(): string
    {
        return $this->guid;
    }

    public function authenticate(Service $service): void
    {
        $guidCallerIdObject = new class { public $ExternalCallerId; };
        $guidCallerIdObject->ExternalCallerId = $this->getGuid();

        $service->customHeader(
            new SoapHeader('http://www.i-label.net/Partners/WebServices/DataFeed/2005/11', 'ExternalCallerHeader', $guidCallerIdObject)
        );
    }
}