<?php

namespace BrandbankSOAPAPIClient\Request\SupplyCoverageReport;

use BrandbankSOAPAPIClient\Traits\XmlCutHeaderTrait;

class xmlData
{
    use XmlCutHeaderTrait;

    private $retailerFeedbackReport = '';

    public function __construct(?RetailerFeedbackReport $retailerFeedbackReport = null)
    {
        if (null !== $retailerFeedbackReport) {
            $this->retailerFeedbackReport = $retailerFeedbackReport;
        }
    }

    public function getRetailerFeedbackReport(): RetailerFeedbackReport
    {
        return $this->retailerFeedbackReport;
    }

    public function setRetailerFeedbackReport(RetailerFeedbackReport $retailerFeedbackReport): self
    {
        $this->retailerFeedbackReport = $retailerFeedbackReport;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'any' => self::cutXmlVersionHeader($this->retailerFeedbackReport->toXml()->asXML())
        ];
    }
}