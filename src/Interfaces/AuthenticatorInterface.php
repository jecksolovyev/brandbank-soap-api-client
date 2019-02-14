<?php

namespace BrandbankSOAPAPIClient\Interfaces;

use Artisaninweb\SoapWrapper\Service;

interface AuthenticatorInterface
{
    public function authenticate(Service $service): void;
}