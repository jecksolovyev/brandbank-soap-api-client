<?php

namespace BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult;

class FrontOfPackGDA extends AbstractItem
{

    public static function newFromXml(\SimpleXMLElement $xml): self
    {
        $o = new self();

        // parse attributes
        $o->setId((int)$xml->attributes()->Id);
        $o->setName((string)$xml->attributes()->Name);

        return $o;
    }

    public function hash(): string
    {
        return md5($this->getId());
    }
}