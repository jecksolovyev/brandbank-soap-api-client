<?php

namespace BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult;

use Ds\Map;

class TextualNutrition extends AbstractItem
{
    /** @var Map */
    protected $nutrients;
    protected $heading;

    public function __construct()
    {
        $this->nutrients = new Map();
        $this->heading = '';
    }

    public function getHeading(): string
    {
        return $this->heading;
    }

    public function setHeading(string $heading): void
    {
        $this->heading = $heading;
    }

    public function addNutrient(string $name, string $value): void
    {
        $this->nutrients->put($name, $value);
    }

    /**
     * @param callable|null $filterCallback
     * @return array
     */
    public function getNutrients(?callable $filterCallback = null): array
    {
        if ($filterCallback === null) {
            // do not filter
            return $this->nutrients->toArray();
        }

        return $this->nutrients->filter($filterCallback)->toArray();
    }

    public function hasNutrients(): bool
    {
        return !$this->nutrients->isEmpty();
    }

    public static function newFromXml(\SimpleXMLElement $xml): self
    {
        $o = new self();

        // parse attributes
        $o->setId((int)$xml->attributes()->Id);
        $o->setName((string)$xml->attributes()->Name);

        // parse headings
        $headings = $xml->xpath('Headings/Heading');
        foreach ($headings as $heading) {
            $o->setHeading((string)$heading);
        }

        // parse nutritions
        $nutrients = $xml->xpath('Nutrient');
        foreach ($nutrients as $nutrient) {
            $o->addNutrient((string)$nutrient->Name, (string)$nutrient->Values->Value);
        }

        return $o;
    }

    public function hash(): string
    {
        return md5($this->getId());
    }
}