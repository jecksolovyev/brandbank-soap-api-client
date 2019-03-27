<?php

namespace BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult;

use Ds\Hashable;

class NameValueText implements Hashable
{
    protected $NameId;
    protected $Name;
    protected $Value;
    protected $ValueId;
    protected $Text;

    public static function newFromXml(\SimpleXMLElement $xml): self
    {
        $o = new self();

        $o->setNameId((int)$xml->Name->attributes()->Id);
        $o->setName((string)$xml->Name);
        $o->setValueId((int)$xml->Value->attributes()->Id);
        $o->setValue((string)$xml->Value);
        $o->setText((string)$xml->Text);

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
    
    public function getText(): string
    {
        return $this->Text;
    }
    
    public function setText(string $string): void
    {
        $this->Text = $string;
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
        return md5($this->getValueId() . '-' . $this->getNameId() . '-' . $this->getText());
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