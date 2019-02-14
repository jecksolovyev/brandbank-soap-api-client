<?php

namespace BrandbankSOAPAPIClient\Request\SupplyCoverageReport;

use BrandbankSOAPAPIClient\Traits\ClassShortNameTrait;

class SupplyCoverageReport
{
    use ClassShortNameTrait;

    private $xmlData;

    public function __construct(?xmlData $xmlData = null)
    {
        if (null !== $xmlData) {
            $this->xmlData = $xmlData;
        }
    }

    public function getXmlData(): xmlData
    {
        return $this->xmlData;
    }

    public function setXmlData(xmlData $xmlData): self
    {
        $this->xmlData = $xmlData;

        return $this;
    }

    public function toArray(): array
    {
        return [
            self::getShortClassName(xmlData::class) => $this->xmlData->toArray()
        ];
    }
}