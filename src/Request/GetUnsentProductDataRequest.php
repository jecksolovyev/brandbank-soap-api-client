<?php

namespace BrandbankSOAPAPIClient\Request;

use BrandbankSOAPAPIClient\Interfaces\RequestInterface;

class GetUnsentProductDataRequest implements RequestInterface
{

    public static function getSOAPMethodName(): string
    {
        return 'GetUnsentProductData';
    }

    public function toArray(): array
    {
        return [];
    }
}