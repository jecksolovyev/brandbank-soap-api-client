<?php

namespace BrandbankSOAPAPIClient\Traits;

trait XmlCutHeaderTrait
{
    private static function cutXmlVersionHeader(string $xmlCode): string
    {
        return str_replace('<?xml version="1.0"?>', '', $xmlCode);
    }
}