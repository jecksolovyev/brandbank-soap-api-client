<?php

namespace BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult;

use BrandbankSOAPAPIClient\Exception\BrandbankSOAPException;
use Ds\Hashable;

class TargetMarket implements Hashable
{
    private $code;

    /**
     * TargetMarket constructor
     *
     * @param string $code
     * @throws BrandbankSOAPException
     */
    public function __construct(string $code)
    {
        if (!preg_match('/^[A-Z]{2}$/', $code)) {
            throw new BrandbankSOAPException('Code should be [A-Z]{2}');
        }

        $this->code = $code;
    }

    public static function newFromXml(\SimpleXMLElement $xml): self
    {
        return new self((string)$xml->attributes()->Code);
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function hash()
    {
        return md5($this->code);
    }

    public function equals($obj): bool
    {
        if ($obj === $this) {
            return true;
        }

        if (!$obj instanceof self) {
            return false;
        }

        return $obj->hash() === $this->hash();
    }
}