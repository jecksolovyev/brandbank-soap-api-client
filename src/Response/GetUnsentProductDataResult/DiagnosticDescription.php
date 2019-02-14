<?php

namespace BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult;

use BrandbankSOAPAPIClient\Exception\BrandbankSOAPException;

class DiagnosticDescription
{
    /** @var Language */
    private $code;
    private $text;

    /**
     * DiagnosticDescription constructor
     *
     * @param string $text
     * @param string $code
     * @throws BrandbankSOAPException
     */
    public function __construct(string $text, string $code)
    {
        $this->code = new Language($code);
        $this->text = $text;
    }

    public static function newFromXml(\SimpleXMLElement $xml): self
    {
        // xml sample <DiagnosticDescription Code="en-GB">Kinder Bueno Milk and Hazelnuts Bar 4 x 43g</DiagnosticDescription>

        return new self(
            (string)$xml,
            (string)$xml->attributes()->Code
        );
    }

    public function getCode(): Language
    {
        return $this->code;
    }

    public function getText(): string
    {
        return $this->text;
    }
}