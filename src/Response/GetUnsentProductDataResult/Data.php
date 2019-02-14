<?php

namespace BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult;

use Ds\Set;

class Data
{
    /** @var Set */
    private $languages;

    public function __construct()
    {
        $this->languages = new Set();
    }

    public static function newFromXml(\SimpleXMLElement $xml): self
    {
        $o = new self();

        // parse Languages (minOccurs="1" maxOccurs="unbounded")
        $langs = $xml->xpath("Language");
        foreach ($langs as $lang) {
            $o->addLanguage(DataLanguage::newFromXml($lang));
        }

        return $o;
    }

    public function addLanguage(DataLanguage $language): void
    {
        $this->languages->add($language);
    }

    /**
     * @param callable|null $filterCallback
     * @return DataLanguage[]
     */
    public function getLanguages(?callable $filterCallback = null): array
    {
        if (null === $filterCallback) {
            // do not filter
            return $this->languages->toArray();
        }

        return $this->languages->filter($filterCallback)->toArray();
    }

    public function hasLanguage(): bool
    {
        return !$this->languages->isEmpty();
    }
}