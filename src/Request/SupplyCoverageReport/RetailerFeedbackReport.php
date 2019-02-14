<?php

namespace BrandbankSOAPAPIClient\Request\SupplyCoverageReport;

use BrandbankSOAPAPIClient\Interfaces\XmlableInterface;
use BrandbankSOAPAPIClient\Traits\XmlAppendChildTrait;
use Ds\Map;
use SimpleXMLElement;

class RetailerFeedbackReport implements XmlableInterface
{
    use XmlAppendChildTrait;

    private $message;
    private $items;

    public function __construct(Message $message)
    {
        $this->message = $message;
        $this->items = new Map();
    }

    public function getMessage(): Message
    {
        return $this->message;
    }

    public function setMessage(Message $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function hasItems(): bool
    {
        return !$this->items->isEmpty();
    }

    public function addItem(Item $item): self
    {
        if ($this->items->hasKey($item->getGtin())) {
            throw new \InvalidArgumentException('Duplicate GTIN in items list');
        }

        $this->items->put($item->getGtin(), $item);

        return $this;
    }

    public function toXml(): SimpleXMLElement
    {
        $el = new SimpleXMLElement('<RetailerFeedbackReport xmlns="http://www.brandbank.com/schemas/CoverageFeedback/2005/11" />');
        self::appendChild($el, $this->getMessage()->toXml());

        foreach ($this->items->toArray() as $item) {
            /** @var Item $item */
            self::appendChild($el, $item->toXml());
        }

        return $el;
    }
}