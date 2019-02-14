<?php

namespace BrandbankSOAPAPIClient\Request\SupplyCoverageReport;

use BrandbankSOAPAPIClient\Interfaces\XmlableInterface;
use BrandbankSOAPAPIClient\Traits\XmlAppendChildTrait;
use SimpleXMLElement;

class Item implements XmlableInterface
{
    use XmlAppendChildTrait;

    private $hasLabelData = true;
    private $hasImage = true;
    private $description = '';
    private $gtin = '';
    private $ownLabel = false;

    /**
     * Item constructor.
     * @param bool $hasLabelData
     * @param bool $hasImage
     * @param string $description
     * @param string $gtin
     * @param bool $ownLabel
     */
    public function __construct(string $gtin, string $description = '', bool $ownLabel = false, bool $hasLabelData = true, bool $hasImage = true)
    {
        $this->hasLabelData = $hasLabelData;
        $this->hasImage = $hasImage;
        $this->description = $description;
        $this->gtin = $gtin;
        $this->ownLabel = $ownLabel;
    }


    public function isHasLabelData(): bool
    {
        return $this->hasLabelData;
    }

    public function setHasLabelData(bool $hasLabelData): void
    {
        $this->hasLabelData = $hasLabelData;
    }

    public function isHasImage(): bool
    {
        return $this->hasImage;
    }

    public function setHasImage(bool $hasImage): void
    {
        $this->hasImage = $hasImage;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getGtin(): string
    {
        return $this->gtin;
    }

    public function setGtin(string $gtin): void
    {
        $this->gtin = $gtin;
    }

    public function isOwnLabel(): bool
    {
        return $this->ownLabel;
    }

    public function setOwnLabel(bool $ownLabel): void
    {
        $this->ownLabel = $ownLabel;
    }

    public function toXml(): SimpleXMLElement
    {
        $itemEl = new SimpleXMLElement('<Item />');

        $itemEl->addAttribute('HasLabelData', $this->hasLabelData ? 'true' : 'false');
        $itemEl->addAttribute('HasImage', $this->hasImage ? 'true' : 'false');

        $itemEl->addChild('RetailerID', $this->gtin);
        $itemEl->addChild('Description', empty($this->description) ? 'UNKNOWN' : $this->description);

        $gtinEl = new SimpleXMLElement('<GTIN><Suppliers><Supplier><SupplierName>UNKNOWN</SupplierName></Supplier></Suppliers></GTIN>');
        $gtinEl->addAttribute('Value', $this->gtin);

        $gtinsEl = new SimpleXMLElement('<GTINs />');
        self::appendChild($gtinsEl, $gtinEl);
        self::appendChild($itemEl, $gtinsEl);

        $itemEl->addChild('OwnLabel', $this->ownLabel ? 'true' : 'false');

        $catEl = new SimpleXMLElement('<Categories><Category>UNKNOWN</Category></Categories>');
        self::appendChild($itemEl, $catEl);

        return $itemEl;
    }
}