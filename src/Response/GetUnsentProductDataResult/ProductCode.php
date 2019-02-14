<?php

namespace BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult;

use BrandbankSOAPAPIClient\Exception\BrandbankSOAPException;
use Ds\Hashable;

class ProductCode implements Hashable
{
    const SCHEME_BRANDBANK_PVID = 'BRANDBANK:PVID';
    const SCHEME_GTIN = 'GTIN';

    private $code;
    private $scheme;
    /**
     * Used to express modifications such as (removed check digit/price digits etc.), optional
     *
     * @var string
     */
    private $qualifier;

    public function __construct(string $code, string $scheme, ?string $qualifier = null)
    {
        if (!preg_match('/^\S+$/', $code)) {
            throw new BrandbankSOAPException('Code should be \S+');
        }

        if (!preg_match('/^\S{2,25}$/', $scheme)) {
            throw new BrandbankSOAPException('Scheme should be \S{2,25}');
        }

        $this->code = $code;
        $this->scheme = $scheme;
        $this->qualifier = empty($qualifier) ? null : $qualifier;
    }

    public static function newFromXml(\SimpleXMLElement $xml): self
    {
        return new self(
            (string) $xml,
            (string) $xml->attributes()->Scheme,
            (string) $xml->attributes()->Qualifier
        );
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getScheme(): string
    {
        return $this->scheme;
    }

    public function getQualifier(): ?string
    {
        return $this->qualifier;
    }

    public function hash()
    {
        return md5($this->code . '-' . $this->scheme);
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