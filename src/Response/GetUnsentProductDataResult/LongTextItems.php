<?php

namespace BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult;

use Ds\Set;

class LongTextItems extends AbstractItem
{
    /** @var Set */
    protected $texts;

    public function __construct()
    {
        $this->texts = new Set();
    }

    public function addText(string $name): void
    {
        $this->texts->add($name);
    }

    /**
     * @param callable|null $filterCallback
     * @return array
     */
    public function getTexts(?callable $filterCallback = null): array
    {
        if ($filterCallback === null) {
            // do not filter
            return $this->texts->toArray();
        }

        return $this->texts->filter($filterCallback)->toArray();
    }

    public function hasTexts(): bool
    {
        return !$this->texts->isEmpty();
    }

    public static function newFromXml(\SimpleXMLElement $xml): self
    {
        $o = new self();

        // parse attributes
        $o->setId((int)$xml->attributes()->Id);
        $o->setName((string)$xml->attributes()->Name);

        // parse items in group
        $texts = $xml->children();
        foreach ($texts as $text) {
            $o->addText((string)$text);
        }

        return $o;
    }

    public function hash(): string
    {
        return md5($this->getId());
    }
}