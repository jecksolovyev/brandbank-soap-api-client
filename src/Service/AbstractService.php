<?php

namespace BrandbankSOAPAPIClient\Service;

use BrandbankSOAPAPIClient\Interfaces\AuthenticatorInterface;
use BrandbankSOAPAPIClient\Interfaces\ServiceInterface;

abstract class AbstractService implements ServiceInterface
{
    /** @var AuthenticatorInterface */
    private $authenticator;

    public function __construct(AuthenticatorInterface $authenticator)
    {
        $this->authenticator = $authenticator;
    }

    public function getAuthenticator(): AuthenticatorInterface
    {
        return $this->authenticator;
    }
}