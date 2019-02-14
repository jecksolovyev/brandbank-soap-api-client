<?php


namespace BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult;


use BrandbankSOAPAPIClient\Exception\BrandbankSOAPException;
use Ds\Hashable;

abstract class AbstractItem implements Hashable
{
    protected $Id;
    protected $Name;
    protected $DisplayOrder; // optional

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

    public static abstract function newFromXml(\SimpleXMLElement $xml);

    /**
     * @param \SimpleXMLElement $xml
     * @return static
     * @throws BrandbankSOAPException
     */
    public static function newFromXmlFactory(\SimpleXMLElement $xml)
    {
        // form full qualified class name
        $itemClassName = '\\' . __NAMESPACE__ . '\\' .  $xml->getName();

        if (!class_exists($itemClassName)) {
            throw new BrandbankSOAPException('Class ' . $itemClassName . ' is not exists');
        }

        return $itemClassName::newFromXml($xml);
    }

    public abstract function hash(): string;

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