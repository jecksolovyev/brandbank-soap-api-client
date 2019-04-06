<?php

namespace BrandbankSOAPAPIClient\Request;

use BrandbankSOAPAPIClient\Interfaces\RequestInterface;
use BrandbankSOAPAPIClient\Request\SupplyCoverageReport\AcknowledgeMessage;
use BrandbankSOAPAPIClient\Traits\ClassShortNameTrait;

class AcknowledgeMessageRequest implements RequestInterface
{
    use ClassShortNameTrait;
    
    private $acknowledgeMessage;
    
    public function __construct(?AcknowledgeMessage $AcknowledgeMessage = null)
    {
        if (null !== $AcknowledgeMessage) {
            $this->acknowledgeMessage = $AcknowledgeMessage;
        }
    }
    
    public static function getSOAPMethodName(): string
    {
        return self::getShortClassName(AcknowledgeMessage::class);
    }
    
    public function toArray(): array
    {
        return [
            self::getShortClassName(AcknowledgeMessage::class) => $this->acknowledgeMessage->toArray()
        ];
    }
}