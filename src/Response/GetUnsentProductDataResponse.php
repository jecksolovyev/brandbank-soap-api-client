<?php

namespace BrandbankSOAPAPIClient\Response;

use BrandbankSOAPAPIClient\Interfaces\ResponseInterface;

class GetUnsentProductDataResponse implements ResponseInterface
{
    private $GetUnsentProductDataResult;

    public function getUnsentProductDataResult(): GetUnsentProductDataResult
    {
        return $this->GetUnsentProductDataResult;
    }
}