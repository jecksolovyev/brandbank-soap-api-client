<?php

namespace BrandbankSOAPAPIClient\Response;

use BrandbankSOAPAPIClient\Interfaces\ResponseInterface;

class SupplyCoverageReportResponse implements ResponseInterface
{
    /**
     *  0 = Success
     * -1 = General Failure (i.e. wrong GUID credential provided, incorrect feed ACL configured.)
     * -2 = NullReferencePassed (de-serialized soap message has no content, no zip provided, etc.)
     *
     * @var int
     */
    private $SupplyCoverageReportResult = 0;

    /**
     * Success
     *
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->SupplyCoverageReportResult === 0;
    }

    /**
     * General Failure (i.e. wrong GUID credential provided, incorrect feed ACL configured.)
     *
     * @return bool
     */
    public function isContentError(): bool
    {
        return $this->SupplyCoverageReportResult === -1;
    }

    /**
     * NullReferencePassed (de-serialized soap message has no content, no zip provided, etc.)
     */
    public function isXMLError(): bool
    {
        return $this->SupplyCoverageReportResult === -2;
    }
}