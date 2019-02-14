<?php

namespace BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult;

use Ds\Hashable;
use Ds\Set;

class ItemTypeGroup implements Hashable
{
    private $Id;
    private $Name;
    private $DisplayOrder; // optional
    /** @var Set */
    private $items; // unbounded

    public function __construct()
    {
        $this->items = new Set();
    }

    public function addItem(AbstractItem $item): void
    {
        $this->items->add($item);
    }

    /**
     * @param callable|null $filterCallback
     * @return AbstractItem[]
     */
    public function getItems(?callable $filterCallback = null): array
    {
        if ($filterCallback === null) {
            // do not filter
            return $this->items->toArray();
        }

        return $this->items->filter($filterCallback)->toArray();
    }

    public function hasItems(): bool
    {
        return !$this->items->isEmpty();
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

        // parse items in group
        $items = $xml->children();
        foreach ($items as $item) {
            $o->addItem(AbstractItem::newFromXmlFactory($item));
        }

//        print_r(array_keys((array) $xml->children())); die;
//        print_r($o); die;

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

    public function setName(string $Name): void
    {
        $this->Name = $Name;
    }

    public function getDisplayOrder(): ?int
    {
        return $this->DisplayOrder;
    }

    public function setDisplayOrder(?int $DisplayOrder): void
    {
        $this->DisplayOrder = $DisplayOrder;
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