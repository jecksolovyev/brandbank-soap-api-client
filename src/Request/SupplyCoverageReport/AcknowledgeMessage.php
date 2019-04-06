<?php

namespace BrandbankSOAPAPIClient\Request\SupplyCoverageReport;

use BrandbankSOAPAPIClient\Traits\ClassShortNameTrait;

class AcknowledgeMessage
{
    use ClassShortNameTrait;
    
    private $messageGuid;
    
    public function __construct(?string $messageGuid)
    {
        $this->messageGuid = $messageGuid;
    }
    
    public function getMessageGuid(): ?string
    {
        return $this->messageGuid;
    }
    
    public function toArray(): array
    {
        return [
            'messageGuid' => $this->messageGuid
        ];
    }
}