<?php

namespace BrandbankSOAPAPIClient\Interfaces;

interface RequestInterface
{
    public static function getSOAPMethodName(): string;
    public function toArray(): array;
}