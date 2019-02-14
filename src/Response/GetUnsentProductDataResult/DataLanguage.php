<?php

namespace BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult;

use BrandbankSOAPAPIClient\Exception\BrandbankSOAPException;
use Ds\Hashable;
use Ds\Set;

class DataLanguage implements Hashable
{
    private $Description; // required
    private $Categorisations; // set minOccurs="0" maxOccurs="1"
    private $ItemTypeGroups; // minOccurs="0" maxOccurs="unbounded"

    /** @var Language */
    private $Code; // required
    private $Source; // required
    private $GroupingSetId; // required
    private $GroupingSetName; // required

    const SOURCE_OFF_PACK = 'OffPack';
    const SOURCE_IMPLICIT_TRANSLATION = 'ImplicitTranslation';
    const SOURCE_EXPLICIT_TRANSLATION = 'ExplicitTranslation';

    public function __construct()
    {
        $this->Categorisations = new Set();
        $this->ItemTypeGroups = new Set();
    }

    public function getCode(): Language
    {
        return $this->Code;
    }

    public function setCode(Language $Code): void
    {
        $this->Code = $Code;
    }

    public function getSource(): string
    {
        return $this->Source;
    }

    public function setSource(string $Source): void
    {
        if (!in_array($Source, [self::SOURCE_EXPLICIT_TRANSLATION, self::SOURCE_IMPLICIT_TRANSLATION, self::SOURCE_OFF_PACK])) {
            throw new BrandbankSOAPException('Source must be one of allowed');
        }

        $this->Source = $Source;
    }

    public function getGroupingSetId(): int
    {
        return $this->GroupingSetId;
    }

    public function setGroupingSetId(int $GroupingSetId): void
    {
        $this->GroupingSetId = $GroupingSetId;
    }

    public function getGroupingSetName(): string
    {
        return $this->GroupingSetName;
    }

    public function setGroupingSetName(string $GroupingSetName): void
    {
        $this->GroupingSetName = $GroupingSetName;
    }

    public function getDescription(): string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): void
    {
        $this->Description = $Description;
    }

    public function addCategorisation(Categorisation $categorisation): void
    {
        $this->Categorisations->add($categorisation);
    }

    /**
     * @param callable|null $filterCallback
     * @return Categorisation[]
     */
    public function getCategorisations(?callable $filterCallback = null): array
    {
        if ($filterCallback === null) {
            // do not filter
            return $this->Categorisations->toArray();
        }

        return $this->Categorisations->filter($filterCallback)->toArray();
    }

    public function hasCategorisations(): bool
    {
        return !$this->Categorisations->isEmpty();
    }

    public function addItemTypeGroup(ItemTypeGroup $itemTypeGroup): void
    {
        $this->ItemTypeGroups->add($itemTypeGroup);
    }

    /**
     * @param callable|null $filterCallback
     * @return ItemTypeGroup[]
     */
    public function getItemTypeGroups(?callable $filterCallback = null): array
    {
        if ($filterCallback === null) {
            // do not filter
            return $this->ItemTypeGroups->toArray();
        }

        return $this->ItemTypeGroups->filter($filterCallback)->toArray();
    }

    public function hasItemTypeGroups(): bool
    {
        return !$this->ItemTypeGroups->isEmpty();
    }

    public static function newFromXml(\SimpleXMLElement $xml): self
    {
        $o = new self();

        // parse attributes
        $o->setGroupingSetId((int)$xml->attributes()->GroupingSetId);
        $o->setGroupingSetName((string)$xml->attributes()->GroupingSetName);
        $o->setSource((string)$xml->attributes()->Source);
        $o->setCode(new Language((string)$xml->attributes()->Code));

        // parse Description
        if (array_key_exists('Description', (array)$xml->children())) {
            $o->setDescription((string)$xml->Description);
        }

        // parse Categorisations (minOccurs="0" maxOccurs="1")
        $cats = $xml->xpath("Categorisations/Categorisation");
        foreach ($cats as $cat) {
            $o->addCategorisation(Categorisation::newFromXml($cat));
        }

        // parse ItemTypeGroup (minOccurs="0" maxOccurs="unbounded")
        $itemTypeGroups = $xml->xpath("ItemTypeGroup");
        foreach ($itemTypeGroups as $itemTypeGroup) {
            $o->addItemTypeGroup(ItemTypeGroup::newFromXml($itemTypeGroup));
        }

        return $o;
    }

    public function hash()
    {
        return md5($this->getCode());
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