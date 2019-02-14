<?php

namespace BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult;

use BrandbankSOAPAPIClient\Exception\BrandbankSOAPException;

class Subscription
{
    private $code;
    private $id;
    private $text;

    public function __construct(string $text, string $code, int $id)
    {
        if (!preg_match('/^[O|A][A-Z0-9]{3}[0-9]{3}$/', $code)) {
            throw new BrandbankSOAPException('Code should be [O|A][A-Z0-9]{3}[0-9]{3}');
        }

        if ($id < 0) {
            throw new BrandbankSOAPException('Id should be any positive integer');
        }

        $this->code = $code;
        $this->id = $id;
        $this->text = $text;
    }

    public static function newFromXml(\SimpleXMLElement $xml): self
    {
        // xml sample <Subscription Id="54400" Code="OBBD001">Brandbank Demo (Grocery)</Subscription>

        return new self(
            (string)$xml,
            (string)$xml->attributes()->Code,
            (string)$xml->attributes()->Id
        );
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getText(): string
    {
        return $this->text;
    }
}