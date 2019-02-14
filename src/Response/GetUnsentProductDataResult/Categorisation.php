<?php

namespace BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult;

use Ds\Hashable;
use Ds\Set;

class Categorisation implements Hashable
{
    private $scheme;
    private $levels;

    public function __construct()
    {
        $this->levels = new Set();
    }

    public function getScheme(): string
    {
        return $this->scheme;
    }

    public function setScheme(string $scheme): void
    {
        $this->scheme = $scheme;
    }

    public function addLevel(Level $level): void
    {
        $this->levels->add($level);
    }

    /**
     * @param callable|null $filterCallback
     * @return Level[]
     */
    public function getLevels(?callable $filterCallback = null): array
    {
        if ($filterCallback === null) {
            // do not filter
            return $this->levels->toArray();
        }

        return $this->levels->filter($filterCallback)->toArray();
    }

    public function hasLevels(): bool
    {
        return !$this->levels->isEmpty();
    }

    public static function newFromXml(\SimpleXMLElement $xml): self
    {
        $o = new self();

        // parse attributes
        $o->setScheme((string)$xml->attributes()->Scheme);

        // parse Level (minOccurs="1" maxOccurs="unbounded")
        $levels = $xml->xpath("Level");
        foreach ($levels as $level) {
            $o->addLevel(Level::newFromXml($level));
        }

        return $o;
    }

    public function hash()
    {
        return md5($this->getScheme());
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