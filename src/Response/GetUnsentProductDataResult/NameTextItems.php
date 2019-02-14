<?php

namespace BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult;

use Ds\Set;

class NameTextItems extends AbstractItem
{
    /** @var Set */
    private $nameTexts; // minOccurs="1" maxOccurs="unbounded"

    public function __construct()
    {
        $this->nameTexts = new Set();
    }

    public function addNameText(NameText $item): void
    {
        $this->nameTexts->add($item);
    }

    /**
     * @param callable|null $filterCallback
     * @return NameText[]
     */
    public function getNameTexts(?callable $filterCallback = null): array
    {
        if ($filterCallback === null) {
            // do not filter
            return $this->nameTexts->toArray();
        }

        return $this->nameTexts->filter($filterCallback)->toArray();
    }

    public function hasNameTexts(): bool
    {
        return !$this->nameTexts->isEmpty();
    }

    public static function newFromXml(\SimpleXMLElement $xml): self
    {
        $o = new self();

        // parse attributes
        $o->setId((int)$xml->attributes()->Id);
        $o->setName((string)$xml->attributes()->Name);
        if (null !== $xml->attributes()->DisplayOrder) {
            $o->setDisplayOrder((int) $xml->attributes()->DisplayOrder);
        }

        // parse contents
        $items = $xml->xpath('NameText');
        foreach ($items as $item) {
            $o->addNameText(NameText::newFromXml($item));
        }

        return $o;
    }

    public function hash(): string
    {
        return md5($this->getId());
    }
}