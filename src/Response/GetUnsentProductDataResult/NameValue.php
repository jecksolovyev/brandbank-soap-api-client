<?php

namespace BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult;

use Ds\Hashable;

class NameValue implements Hashable
{
    protected $NameId;
    protected $Name;
    protected $Value;
    protected $ValueId;

    public static function newFromXml(\SimpleXMLElement $xml): self
    {
        $o = new self();

        $o->setNameId((int)$xml->Name->attributes()->Id);
        $o->setName((string)$xml->Name);
        $o->setValueId((int)$xml->Value->attributes()->Id);
        $o->setValue((string)$xml->Value);

        return $o;
    }

    public function getValueId(): int
    {
        return $this->ValueId;
    }

    public function setValueId(int $Id): void
    {
        $this->ValueId = $Id;
    }

    public function getNameId(): int
    {
        return $this->NameId;
    }

    public function setNameId(int $Id): void
    {
        $this->NameId = $Id;
    }

    public function getName(): string
    {
        return $this->Name;
    }

    public function setName(string $name): void
    {
        $this->Name = $name;
    }

    public function getValue(): string
    {
        return $this->Value;
    }

    public function setValue(string $value): void
    {
        $this->Value = $value;
    }

    public function hash()
    {
        return md5($this->getValueId() . '-' . $this->getNameId());
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