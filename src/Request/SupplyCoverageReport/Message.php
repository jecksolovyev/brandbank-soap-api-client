<?php

namespace BrandbankSOAPAPIClient\Request\SupplyCoverageReport;

use BrandbankSOAPAPIClient\Interfaces\XmlableInterface;
use SimpleXMLElement;

class Message implements XmlableInterface
{
    private $dateTime;
    private $domain;

    public const DOMAIN = 'LST';

    public function __construct(\DateTime $dateTime, ?string $domain = null)
    {
        $this->dateTime = $dateTime;
        $this->setDomain($domain);
    }

    public function getDateTime(): \DateTime
    {
        return $this->dateTime;
    }

    public function setDateTime(\DateTime $dateTime): self
    {
        $this->dateTime = $dateTime;

        return $this;
    }

    public function getDomain(): string
    {
        return $this->domain;
    }

    public function setDomain(?string $domain): self
    {
        $this->domain = empty($domain) ? self::DOMAIN : $domain;

        return $this;
    }

    public function toXml(): SimpleXMLElement
    {
        $e = new \SimpleXMLElement('<Message />');
        $e->addAttribute('DateTime', $this->getDateTime()->format(DATE_RFC3339_EXTENDED));
        $e->addAttribute('Domain', $this->getDomain());

        return $e;
    }
}