<?php

namespace BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult;

use Ds\Set;

class NameTextLookups extends AbstractItem
{
    /** @var Set */
    private $list; // minOccurs="0" maxOccurs="unbounded"

    public function __construct()
    {
        $this->list = new Set();
    }

    public function addNameValueText(NameValueText $item): void
    {
        $this->list->add($item);
    }

    /**
     * @param callable|null $filterCallback
     * @return NameValueText[]
     */
    public function getNameValueTexts(?callable $filterCallback = null): array
    {
        if ($filterCallback === null) {
            // do not filter
            return $this->list->toArray();
        }

        return $this->list->filter($filterCallback)->toArray();
    }

    public function hasNameValueTexts(): bool
    {
        return !$this->list->isEmpty();
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
        $items = $xml->xpath('NameValueText'); // minOccurs="1" maxOccurs="unbounded"
        foreach ($items as $item) {
            $o->addNameValueText(NameValueText::newFromXml($item));
        }

        return $o;
    }

    public function hash(): string
    {
        return md5($this->getId());
    }
}