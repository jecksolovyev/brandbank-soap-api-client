<?php

namespace BrandbankSOAPAPIClient\Traits;

trait ClassShortNameTrait
{
    public static function getShortClassName(string $className): string
    {
        return (new \ReflectionClass($className))->getShortName();
    }
}