<?php

namespace BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult;

use Ds\Hashable;

class NameText implements Hashable
{
    protected $Id;
    protected $Name;
    protected $Text;

    public static function newFromXml(\SimpleXMLElement $xml): self
    {
        $o = new self();

        // parse attributes
        $o->setId((int)$xml->Name->attributes()->Id);
        $o->setName((string)$xml->Name);
        $o->setText((string)$xml->Text);

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

    public function getText(): string
    {
        return $this->Text;
    }

    public function setText(string $text): void
    {
        $this->Text = $text;
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