<?php

namespace BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult;

use BrandbankSOAPAPIClient\Exception\BrandbankSOAPException;

class Language
{
    private $code;

    public function __construct(string $code)
    {
        /**
         * @see http://www.ietf.org/rfc/rfc3066.txt
         * pattern specifies the content of section 2.12 of XML 1.0e2 and RFC 3066 (Revised version of RFC 1766).
         */
        if (!preg_match('/^[a-zA-Z]{1,8}(-[a-zA-Z0-9]{1,8})*$/', $code)) {
            throw new BrandbankSOAPException('Language code should be [a-zA-Z]{1,8}(-[a-zA-Z0-9]{1,8})*');
        }

        $this->code = $code;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function __toString(): string
    {
        return $this->getCode();
    }
}