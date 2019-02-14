<?php

namespace BrandbankSOAPAPIClient\Interfaces;

use Artisaninweb\SoapWrapper\Service;

interface ServiceInterface
{
    public function __construct(AuthenticatorInterface $authenticator);
    public function __invoke(Service $service): void;
}