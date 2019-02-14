<?php

namespace BrandbankSOAPAPIClient\Interfaces;

use SimpleXMLElement;

interface XmlableInterface
{
    public function toXml(): SimpleXMLElement;
}