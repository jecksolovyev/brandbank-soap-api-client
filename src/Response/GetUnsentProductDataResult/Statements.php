<?php

namespace BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult;

use Ds\Map;

class Statements extends AbstractItem
{
    /** @var Map */
    protected $statements;

    public function __construct()
    {
        $this->statements = new Map();
    }

    public function addStatement(int $id, string $name): void
    {
        $this->statements->put($id, $name);
    }

    /**
     * @param callable|null $filterCallback
     * @return array
     */
    public function getStatements(?callable $filterCallback = null): array
    {
        if ($filterCallback === null) {
            // do not filter
            return $this->statements->toArray();
        }

        return $this->statements->filter($filterCallback)->toArray();
    }

    public function hasStatements(): bool
    {
        return !$this->statements->isEmpty();
    }

    public static function newFromXml(\SimpleXMLElement $xml): self
    {
        $o = new self();

        // parse attributes
        $o->setId((int)$xml->attributes()->Id);
        $o->setName((string)$xml->attributes()->Name);

        // parse items in group
        $statements = $xml->children();
        foreach ($statements as $statement) {
            $o->addStatement((int)$statement->attributes()->Id, (string)$statement);
        }

        return $o;
    }

    public function hash(): string
    {
        return md5($this->getId());
    }
}