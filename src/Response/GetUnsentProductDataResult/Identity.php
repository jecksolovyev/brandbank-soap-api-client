<?php

namespace BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult;

use Ds\Set;

class Identity
{
    /** @var Set */
    private $TargetMarkets;
    /** @var Set */
    private $ProductCodes;
    /** @var Subscription */
    private $Subscription;
    /** @var DiagnosticDescription */
    private $DiagnosticDescription;
    /** @var Language */
    private $DefaultLanguage;
    /** @var EU1169_2011Compliance */
    private $Compliance;

    public function __construct()
    {
        $this->TargetMarkets = new Set();
        $this->ProductCodes = new Set();
    }

    /**
     * @param callable|null $filterCallback
     * @return TargetMarket[]
     */
    public function getTargetMarkets(?callable $filterCallback = null): array
    {
        if ($filterCallback === null) {
            // do not filter
            return $this->TargetMarkets->toArray();
        }

        return $this->TargetMarkets->filter($filterCallback)->toArray();
    }

    /**
     * @param callable|null $filterCallback
     * @return ProductCode[]
     */
    public function getProductCodes(?callable $filterCallback = null): array
    {
        if ($filterCallback === null) {
            // do not filter
            return $this->ProductCodes->toArray();
        }

        return $this->ProductCodes->filter($filterCallback)->toArray();
    }

    public function getSubscription(): ?Subscription
    {
        return $this->Subscription;
    }

    public function getDiagnosticDescription(): ?DiagnosticDescription
    {
        return $this->DiagnosticDescription;
    }

    public function getDefaultLanguage(): ?Language
    {
        return $this->DefaultLanguage;
    }

    public function getCompliance(): ?EU1169_2011Compliance
    {
        return $this->Compliance;
    }

    public function hasProductCodes(): bool
    {
        return !$this->ProductCodes->isEmpty();
    }

    public function addProductCode(ProductCode $item): self
    {
        $this->ProductCodes->add($item);

        return $this;
    }

    public function hasTargetMarkets(): bool
    {
        return !$this->TargetMarkets->isEmpty();
    }

    public function addTargetMarket(TargetMarket $item): self
    {
        $this->TargetMarkets->add($item);

        return $this;
    }

    public function setSubscription(Subscription $item): self
    {
        $this->Subscription = $item;

        return $this;
    }

    public function setDiagnosticDescription(DiagnosticDescription $item): self
    {
        $this->DiagnosticDescription = $item;

        return $this;
    }

    public function setDefaultLanguage(Language $item): self
    {
        $this->DefaultLanguage = $item;

        return $this;
    }

    public function setCompliance(EU1169_2011Compliance $item): self
    {
        $this->Compliance = $item;

        return $this;
    }

    public static function newFromXml(\SimpleXMLElement $xml): self
    {
        $o = new self();

        // parse TargetMarkets
        $targetMarkets = $xml->xpath("TargetMarkets/TargetMarket");
        foreach ($targetMarkets as $targetMarket) {
            $o->addTargetMarket(TargetMarket::newFromXml($targetMarket));
        }

        // parse ProductCodes
        $productCodes = $xml->xpath("ProductCodes/Code");
        foreach ($productCodes as $productCode) {
            $o->addProductCode(ProductCode::newFromXml($productCode));
        }

        // parse Subscription
        if (array_key_exists('Subscription', (array)$xml->children())) {
            $o->setSubscription(Subscription::newFromXml($xml->Subscription));
        }

        // parse DiagnosticDescription
        if (array_key_exists('DiagnosticDescription', (array)$xml->children())) {
            $o->setDiagnosticDescription(DiagnosticDescription::newFromXml($xml->DiagnosticDescription));
        }

        // parse DefaultLanguage
        if (array_key_exists('DefaultLanguage', (array)$xml->children())) {
            $o->setDefaultLanguage(new Language((string) $xml->DefaultLanguage));
        }

        // parse Compliance/EU1169_2011 value
        if (
            array_key_exists('Compliance', (array)$xml->children()) &&
            array_key_exists('EU1169_2011', (array)$xml->children()->Compliance)
        ) {
            $o->setCompliance(new EU1169_2011Compliance((string)$xml->Compliance->EU1169_2011));
        }

        return $o;
    }
}