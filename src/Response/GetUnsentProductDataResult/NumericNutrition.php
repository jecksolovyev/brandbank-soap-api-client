<?php

namespace BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult;

use BrandbankSOAPAPIClient\Exception\BrandbankSOAPException;
use Ds\Set;

class NumericNutrition extends AbstractItem
{
    /** @var Set */
    protected $nutrientValues;
    protected $Per100Unit;
    protected $Per100Heading;
    protected $Per100UsedHeading;
    protected $PerServingHeading;

    public const PER100_UNIT_TYPE_ML = 'ml';
    public const PER100_UNIT_TYPE_G = 'g';

    public function __construct()
    {
        $this->nutrientValues = new Set();
    }

    public function getPer100Unit(): ?string
    {
        return $this->Per100Unit;
    }

    public function setPer100Unit(?string $Per100Unit): void
    {
        if (empty($Per100Unit)) {
            return;
        }

        if (!in_array($Per100Unit, [self::PER100_UNIT_TYPE_G, self::PER100_UNIT_TYPE_ML])) {
            throw new BrandbankSOAPException('Per100Unit must be one of allowed');
        }

        $this->Per100Unit = $Per100Unit;
    }

    public function getPer100Heading(): ?string
    {
        return $this->Per100Heading;
    }

    public function setPer100Heading(?string $Per100Heading): void
    {
        if (empty($Per100Heading)) {
            return;
        }

        $this->Per100Heading = $Per100Heading;
    }

    public function getPer100UsedHeading(): ?string
    {
        return $this->Per100UsedHeading;
    }

    public function setPer100UsedHeading(?string $Per100UsedHeading): void
    {
        if (empty($Per100UsedHeading)) {
            return;
        }

        $this->Per100UsedHeading = $Per100UsedHeading;
    }

    public function getPerServingHeading(): ?string
    {
        return $this->PerServingHeading;
    }

    public function setPerServingHeading(?string $PerServingHeading): void
    {
        if (empty($PerServingHeading)) {
            return;
        }

        $this->PerServingHeading = $PerServingHeading;
    }

    public function addNutrientValue(NutritientValue $nutritientValue): void
    {
        $this->nutrientValues->add($nutritientValue);
    }

    /**
     * @param callable|null $filterCallback
     * @return NutritientValue[]
     */
    public function getNutrientValues(?callable $filterCallback = null): array
    {
        if ($filterCallback === null) {
            // do not filter
            return $this->nutrientValues->toArray();
        }

        return $this->nutrientValues->filter($filterCallback)->toArray();
    }

    public function hasNutrientValues(): bool
    {
        return !$this->nutrientValues->isEmpty();
    }

    public static function newFromXml(\SimpleXMLElement $xml): self
    {
        $o = new self();

        // parse attributes
        $o->setId((int)$xml->attributes()->Id);
        $o->setName((string)$xml->attributes()->Name);

        // parse headings
        $o->setPer100Unit((string)$xml->Per100Unit);
        $o->setPer100Heading((string)$xml->Per100Heading);
        $o->setPer100UsedHeading((string)$xml->Per100UsedHeading);
        $o->setPerServingHeading((string)$xml->PerServingHeading);

        // parse nutritions
        $nutrients = $xml->xpath('NutrientValues');
        foreach ($nutrients as $nutrient) {
            $o->addNutrientValue(NutritientValue::newFromXml($nutrient));
        }

        return $o;
    }

    public function hash(): string
    {
        return md5($this->getId());
    }
}