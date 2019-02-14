<?php

namespace BrandbankSOAPAPIClient\Response;

use BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult\Message;

class GetUnsentProductDataResult
{
    private $any;

    public function getMessage()
    {
        return Message::newFromXml(simplexml_load_string($this->any));
    }
}