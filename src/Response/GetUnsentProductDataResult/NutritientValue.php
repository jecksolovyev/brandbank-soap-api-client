<?php

namespace BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult;

use Ds\Hashable;

class NutritientValue implements Hashable
{
    protected $Id;
    protected $Name;
    protected $Per100;
    protected $Per100Used;
    protected $PerServing;

    public function getPer100(): ?string
    {
        return $this->Per100;
    }

    public function setPer100(?string $Per100): void
    {
        if (empty($Per100)) {
            return;
        }

        $this->Per100 = $Per100;
    }

    public function getPer100Used(): ?string
    {
        return $this->Per100Used;
    }

    public function setPer100Used(?string $Per100Used): void
    {
        if (empty($Per100Used)) {
            return;
        }

        $this->Per100Used = $Per100Used;
    }

    public function getPerServing(): ?string
    {
        return $this->PerServing;
    }

    public function setPerServing(?string $PerServing): void
    {
        if (empty($PerServing)) {
            return;
        }

        $this->PerServing = $PerServing;
    }

    public static function newFromXml(\SimpleXMLElement $xml): self
    {
        $o = new self();

        $o->setId((int)$xml->attributes()->Id);
        $o->setName((string)$xml->attributes()->Name);

        // parse values
        $o->setPer100((string)$xml->Per100->Value);
        $o->setPer100Used((string)$xml->Per100Used->Value);
        $o->setPerServing((string)$xml->setPerServing->Value);

        return $o;
    }

    public function getId(): int
    {
        return $this->Id;
    }

    public function setId(int $Id): void
    {
        $this->Id = $Id;
    }

    public function getName(): string
    {
        return $this->Name;
    }

    public function setName(string $name): void
    {
        $this->Name = $name;
    }

    public function hash()
    {
        return md5($this->getId());
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