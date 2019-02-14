<?php

namespace BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult;

use BrandbankSOAPAPIClient\Exception\BrandbankSOAPException;
use Ds\Hashable;
use Ds\Set;

class ImageAsset extends AbstractAsset implements Hashable
{
    private $ShotTypeId;
    private $ShotType;
    private $MimeType;
    private $Id;
    /** @var Set */
    private $Languages;
    /** @var string */
    private $Url;
    /** @var string */
    private $Thumbprint;
    private $Filename;
    private $Width;
    private $Height;
    private $Units;
    private $Quality;
    private $Resolution;
    private $IsCropped;
    private $CropPadding;
    private $IsProhibitUpscale;
    private $MaxSizeInBytes;
    private $IsBestAvailable;
    private $IsTransparent;
    private $BackgroundColour;

    const UNITS_PIXELS = 'Pixels';
    const UNITS_INCHES = 'Inches';
    const UNITS_MILLIMETRES = 'Millimetres';

    public function __construct()
    {
        $this->Languages = new Set();
    }

    public function getBackgroundColour(): ?string
    {
        return $this->BackgroundColour;
    }

    public function setBackgroundColour(string $colorCode): void
    {
        if (!preg_match('/^[0-9A-Fa-f]{8}$/', $colorCode)) {
            throw new BrandbankSOAPException('BackgroundColour should be [0-9A-Fa-f]{8}');
        }

        $this->BackgroundColour = $colorCode;
    }

    public function getWidth(): ?int
    {
        return $this->Width;
    }

    public function setWidth(int $Width): void
    {
        $this->Width = $Width;
    }

    public function getHeight(): ?int
    {
        return $this->Height;
    }

    public function setHeight(int $Height): void
    {
        $this->Height = $Height;
    }

    public function getUnits(): ?string
    {
        return $this->Units;
    }

    public function setUnits(string $Units): void
    {
        if (!in_array($Units, [self::UNITS_INCHES, self::UNITS_MILLIMETRES, self::UNITS_PIXELS])) {
            throw new BrandbankSOAPException('Units must be one of allowed');
        }

        $this->Units = $Units;
    }

    public function getFilename(): ?string
    {
        return $this->Filename;
    }

    public function setFilename(string $Filename): void
    {
        $this->Filename = $Filename;
    }

    public function getQuality(): ?int
    {
        return $this->Quality;
    }

    public function setQuality(int $Quality): void
    {
        $this->Quality = $Quality;
    }

    public function getResolution(): ?int
    {
        return $this->Resolution;
    }

    public function setResolution(int $Resolution): void
    {
        $this->Resolution = $Resolution;
    }

    public function isCropped(): ?bool
    {
        return $this->IsCropped;
    }

    public function setIsCropped(bool $IsCropped): void
    {
        $this->IsCropped = $IsCropped;
    }

    public function getCropPadding(): ?int
    {
        return $this->CropPadding;
    }

    public function setCropPadding(int $CropPadding): void
    {
        $this->CropPadding = $CropPadding;
    }

    public function isProhibitUpscale(): ?bool
    {
        return $this->IsProhibitUpscale;
    }

    public function setIsProhibitUpscale(bool $IsProhibitUpscale): void
    {
        $this->IsProhibitUpscale = $IsProhibitUpscale;
    }

    public function getMaxSizeInBytes(): ?int
    {
        return $this->MaxSizeInBytes;
    }

    public function setMaxSizeInBytes(int $MaxSizeInBytes): void
    {
        $this->MaxSizeInBytes = $MaxSizeInBytes;
    }

    public function isBestAvailable(): ?bool
    {
        return $this->IsBestAvailable;
    }

    public function setIsBestAvailable(bool $IsBestAvailable): void
    {
        $this->IsBestAvailable = $IsBestAvailable;
    }

    public function isTransparent(): ?bool
    {
        return $this->IsTransparent;
    }

    public function setIsTransparent(bool $IsTransparent): void
    {
        $this->IsTransparent = $IsTransparent;
    }

    /**
     * @param callable|null $filterCallback
     * @return Language[]
     */
    public function getLanguages(?callable $filterCallback = null): array
    {
        if ($filterCallback === null) {
            // do not filter
            return $this->Languages->toArray();
        }

        return $this->Languages->filter($filterCallback)->toArray();
    }

    public function hasLanguages(): bool
    {
        return !$this->Languages->isEmpty();
    }

    public function addLanguage(Language $item): self
    {
        $this->Languages->add($item);

        return $this;
    }

    public function getUrl(): string
    {
        return $this->Url;
    }

    public function setUrl(string $url): void
    {
        $this->Url = trim($url);
    }

    public function getShotTypeId(): int
    {
        return $this->ShotTypeId;
    }

    public function setShotTypeId(int $ShotTypeId): void
    {
        $this->ShotTypeId = $ShotTypeId;
    }

    public function getShotType(): string
    {
        return $this->ShotType;
    }

    public function setShotType(string $ShotType): void
    {
        $this->ShotType = $ShotType;
    }

    public function getMimeType(): string
    {
        return $this->MimeType;
    }

    public function setMimeType(string $MimeType): void
    {
        $this->MimeType = $MimeType;
    }

    public function getId(): ?int
    {
        return $this->Id;
    }

    public function setId(int $Id): void
    {
        $this->Id = $Id;
    }

    public function getThumbprint(): string
    {
        return $this->Thumbprint;
    }

    public function setThumbprint(string $Thumbprint): void
    {
        $this->Thumbprint = $Thumbprint;
    }

    public static function newFromXml(\SimpleXMLElement $xml): self
    {
        $o = new self();

        // parse attributes
        $o->setShotTypeId((int) $xml->attributes()->ShotTypeId);
        $o->setShotType((string) $xml->attributes()->ShotType);
        $o->setMimeType((string) $xml->attributes()->MimeType);
        if (null !== $xml->attributes()->Id) {
            $o->setId((int) $xml->attributes()->Id);
        }

        // parse Specification
        if (array_key_exists('Specification', (array) $xml->children())) {

            if (array_key_exists('RequestedDimensions', (array) $xml->Specification)) {
                $o->setUnits((string) $xml->Specification->RequestedDimensions->attributes()->Units);
                $o->setWidth((string) $xml->Specification->RequestedDimensions->Width);
                $o->setHeight((string) $xml->Specification->RequestedDimensions->Height);
            }

            if (array_key_exists('Filename', (array) $xml->Specification)) {
                $o->setFilename((string) $xml->Specification->Filename);
            }

            if (array_key_exists('Quality', (array) $xml->Specification)) {
                $o->setQuality((int) $xml->Specification->Quality);
            }

            if (array_key_exists('Resolution', (array) $xml->Specification)) {
                $o->setResolution((int) $xml->Specification->Resolution);
            }

            if (array_key_exists('IsCropped', (array) $xml->Specification)) {
                $o->setIsCropped((bool) $xml->Specification->IsCropped);
            }

            if (array_key_exists('CropPadding', (array) $xml->Specification)) {
                $o->setCropPadding((int) $xml->Specification->CropPadding);
            }

            if (array_key_exists('IsProhibitUpscale', (array) $xml->Specification)) {
                $o->setIsProhibitUpscale((bool) $xml->Specification->IsProhibitUpscale);
            }

            if (array_key_exists('IsProhibitUpscale', (array) $xml->Specification)) {
                $o->setIsProhibitUpscale((bool) $xml->Specification->IsProhibitUpscale);
            }

            if (array_key_exists('MaxSizeInBytes', (array) $xml->Specification)) {
                $o->setMaxSizeInBytes((int) $xml->Specification->MaxSizeInBytes);
            }

            if (array_key_exists('IsBestAvailable', (array) $xml->Specification)) {
                $o->setIsBestAvailable((bool) $xml->Specification->IsBestAvailable);
            }

            if (array_key_exists('IsTransparent', (array) $xml->Specification)) {
                $o->setIsTransparent((bool) $xml->Specification->IsTransparent);
            }
        }

        // parse Language [0 - unbounded]
        $langs = $xml->xpath("Language");
        foreach ($langs as $lang) {
            $o->addLanguage(new Language((string) $lang->attributes()->Code));
        }

        // parse Url
        if (array_key_exists('Url', (array) $xml->children())) {
            $o->setUrl((string) $xml->Url);
        }

        // parse Thumbprint
        if (array_key_exists('Thumbprint', (array) $xml->children())) {
            $o->setThumbprint((string) $xml->Thumbprint);
        }
        // parse BackgroundColour
        if (array_key_exists('BackgroundColour', (array) $xml->children())) {
            $o->setBackgroundColour((string) $xml->BackgroundColour);
        }

        return $o;
    }

    public function hash()
    {
        return md5($this->getUrl());
    }

    public function equals($obj): bool
    {
        if ($obj === $this) {
            return true;
        }

        if (!$obj instanceof self) {
            return false;
        }

        return $obj->hash() === $this->hash();
    }
}