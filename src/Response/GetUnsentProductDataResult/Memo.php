<?php

namespace BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult;

class Memo extends AbstractItem
{
    protected $Text;

    public static function newFromXml(\SimpleXMLElement $xml): self
    {
        $o = new self();

        // parse attributes
        $o->setId((int)$xml->attributes()->Id);
        $o->setName((string)$xml->attributes()->Name);
        $o->setText((string)$xml);

        return $o;
    }

    public function getText(): string
    {
        return $this->Text;
    }

    public function setText(string $Text): void
    {
        $this->Text = $Text;
    }

    public function hash(): string
    {
        return md5($this->getId());
    }
}