<?php

namespace BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult;

use Ds\Hashable;

class Level implements Hashable
{
    private $code;
    private $text;

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    public static function newFromXml(\SimpleXMLElement $xml): self
    {
        $o = new self();

        $o->setCode((string)$xml->attributes()->Code);
        $o->setText((string)$xml);

        return $o;
    }

    public function hash()
    {
        return md5($this->getCode());
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