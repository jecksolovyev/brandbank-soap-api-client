<?php

namespace BrandbankSOAPAPIClient\Request;

use BrandbankSOAPAPIClient\Interfaces\RequestInterface;
use BrandbankSOAPAPIClient\Request\SupplyCoverageReport\SupplyCoverageReport;
use BrandbankSOAPAPIClient\Traits\ClassShortNameTrait;

class SupplyCoverageReportRequest implements RequestInterface
{
    use ClassShortNameTrait;

    private $supplyCoverageReport;

    public static function getSOAPMethodName(): string
    {
        return self::getShortClassName(SupplyCoverageReport::class);
    }

    public function __construct(?SupplyCoverageReport $SupplyCoverageReport = null)
    {
        if (null !== $SupplyCoverageReport) {
            $this->supplyCoverageReport = $SupplyCoverageReport;
        }
    }

    public function getSupplyCoverageReport(): SupplyCoverageReport
    {
        return $this->supplyCoverageReport;
    }

    public function setSupplyCoverageReport(SupplyCoverageReport $supplyCoverageReport): self
    {
        $this->supplyCoverageReport = $supplyCoverageReport;

        return $this;
    }

    public function toArray(): array
    {
        return [
            self::getShortClassName(SupplyCoverageReport::class) => $this->supplyCoverageReport->toArray()
        ];
    }
}