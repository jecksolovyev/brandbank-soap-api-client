<?php

namespace BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult;

use Ds\Set;

class Message
{
    private $id = '';
    private $dateTime = null;
    private $dataVersion = '';

    private $products;

    public function __construct()
    {
        $this->products = new Set();
    }

    public function hasProducts(): bool
    {
        return !$this->products->isEmpty();
    }

    /**
     * @param callable|null $filterCallback
     * @return Product[]
     */
    public function getProducts(?callable $filterCallback = null): array
    {
        if ($filterCallback === null) {
            // do not filter
            return $this->products->toArray();
        }

        return $this->products->filter($filterCallback)->toArray();
    }

    public function addProduct(Product $item): self
    {
        $this->products->add($item);

        return $this;
    }

    public static function newFromXml(\SimpleXMLElement $xml): self
    {
        $o = new self();

        $o->setId((string) $xml->attributes()->Id);
        $o->setDataVersion((string) $xml->attributes()->DataVersion);
        $o->setDateTime((string) $xml->attributes()->DateTime);

        // parse products
        $products = $xml->xpath("/Message/Product");
        foreach ($products as $product) {
            $o->addProduct(Product::newFromXml($product));
        }

        return $o;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getDateTime(): \DateTime
    {
        return $this->dateTime;
    }

    public function setDateTime(string $dateTime): void
    {
        $this->dateTime = new \DateTime($dateTime);
    }

    public function getDataVersion(): string
    {
        return $this->dataVersion;
    }

    public function setDataVersion(string $dataVersion): void
    {
        $this->dataVersion = $dataVersion;
    }
}