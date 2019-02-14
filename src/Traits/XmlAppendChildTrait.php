<?php

namespace BrandbankSOAPAPIClient\Traits;

trait XmlAppendChildTrait
{
    private static function appendChild(\SimpleXMLElement $appendToElement, \SimpleXMLElement $appendElement)
    {
        $node = $appendToElement->addChild($appendElement->getName(), (string) $appendElement);

        foreach ($appendElement->attributes() as $attr => $value) {
            $node->addAttribute($attr, $value);
        }

        foreach ($appendElement->children() as $ch) {
            self::appendChild($node, $ch);
        }
    }
}