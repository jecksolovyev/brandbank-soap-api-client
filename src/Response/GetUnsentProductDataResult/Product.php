<?php

namespace BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult;

use BrandbankSOAPAPIClient\Exception\BrandbankSOAPException;

class Product
{
    private $versionDateTime;
    private $updateType;
    private $identity; // required and only one
    private $assets;
    private $data;

    const UPDATE_TYPE_DELETE = 'Delete';
    const UPDATE_TYPE_ADD_OR_UPDATE = 'AddOrUpdate';

    public static function newFromXml(\SimpleXMLElement $xml): self
    {
        $o = new self();

        $o->setVersionDateTime((string) $xml->attributes()->VersionDateTime);
        $o->setUpdateType((string) $xml->attributes()->UpdateType);

        // parse Identity
        if (array_key_exists('Identity', (array) $xml)) {
            $o->setIdentity(Identity::newFromXml($xml->Identity));
        }

        // @todo parse Availability
        // @todo parse ExtendedData

        // parse Assets
        $assets = $xml->xpath("Assets");
        if (array_key_exists('Assets', (array) $xml)) {
            $o->setAssets(Assets::newFromXml($xml->Assets));
        }

        // parse Data
        $data = $assets = $xml->xpath("Data");
        if (array_key_exists('Data', (array) $xml)) {
            $o->setData(Data::newFromXml($xml->Data));
        }

        return $o;
    }

    public function getData(): ?Data
    {
        return $this->data;
    }

    public function setData(Data $data): void
    {
        $this->data = $data;
    }

    public function getAssets(): ?Assets
    {
        return $this->assets;
    }

    public function setAssets(Assets $assets): void
    {
        $this->assets = $assets;
    }

    public function getIdentity(): Identity
    {
        return $this->identity;
    }

    public function setIdentity(Identity $identity): void
    {
        $this->identity = $identity;
    }

    public function isUpdateTypeDelete(): bool
    {
        return $this->updateType === self::UPDATE_TYPE_DELETE;
    }

    public function isUpdateTypeAddOrUpdate(): bool
    {
        return $this->updateType === self::UPDATE_TYPE_ADD_OR_UPDATE;
    }

    public function getVersionDateTime(): \DateTime
    {
        return $this->versionDateTime;
    }

    public function setVersionDateTime(string $versionDateTime): void
    {
        $this->versionDateTime = new \DateTime($versionDateTime);
    }

    public function getUpdateType(): string
    {
        return $this->updateType;
    }

    /**
     * @param string $updateType
     * @throws BrandbankSOAPException
     */
    public function setUpdateType(string $updateType): void
    {
        if (!in_array($updateType, [self::UPDATE_TYPE_ADD_OR_UPDATE, self::UPDATE_TYPE_DELETE])) {
            throw new BrandbankSOAPException('Incorrect product updateType');
        }

        $this->updateType = $updateType;
    }
}