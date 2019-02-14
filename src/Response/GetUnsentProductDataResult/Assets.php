<?php

namespace BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult;

use Ds\Set;

class Assets
{
    /** @var Set */
    private $images;

    public function __construct()
    {
        $this->images = new Set();
    }

    public static function newFromXml(\SimpleXMLElement $xml): self
    {
        $o = new self();

        // parse Images
        $images = $xml->xpath("Image");
        foreach ($images as $image) {
            $o->addImage(ImageAsset::newFromXml($image));
        }

        //@todo parse DocumentType

        return $o;
    }

    public function addImage(ImageAsset $image): void
    {
        $this->images->add($image);
    }

    /**
     * @param callable|null $filterCallback
     * @return ImageAsset[]
     */
    public function getImages(?callable $filterCallback = null): array
    {
        if ($filterCallback === null) {
            // do not filter
            return $this->images->toArray();
        }

        return $this->images->filter($filterCallback)->toArray();
    }

    public function hasImages(): bool
    {
        return !$this->images->isEmpty();
    }
}