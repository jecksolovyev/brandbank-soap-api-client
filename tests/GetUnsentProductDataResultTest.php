<?php

use BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult;
use BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult\AbstractItem;
use BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult\DataLanguage;
use BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult\ItemTypeGroup;
use BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult\NameText;
use BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult\NameTextItems;
use BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult\ProductCode;
use PHPUnit\Framework\TestCase;

final class GetUnsentProductDataResultTest extends TestCase
{
    /** @var GetUnsentProductDataResult */
    protected $object;

    protected function setUp()
    {
        parent::setUp();

        $this->object = new GetUnsentProductDataResult();

        // set response XML to GetUnsentProductDataResult object
        $property = (new ReflectionObject($this->object))->getProperty('any');
        $property->setAccessible(true);
        $property->setValue($this->object, $this->getExpectedXml());
    }

    protected function getExpectedXml(): string
    {
        return file_get_contents(__DIR__ . '/xsd/GetUnsentProductData/getUnsentProductDataResult.xml');
    }

    /**
     * @covers SupplyCoverageReportRequest::getSupplyCoverageReport
     * @covers GetUnsentProductDataResult::getMessage
     * @covers \BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult\Message::getProducts
     * @covers \BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult\Message::hasProducts
     * @covers \BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult\Message::newFromXml
     * @covers \BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult\Identity::getProductCodes
     * @covers \BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult\Identity::hasProductCodes
     * @covers \BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult\Identity::hasTargetMarkets
     * @covers \BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult\Product::newFromXml
     * @covers \BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult\TargetMarket::newFromXml
     * @covers \BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult\Identity::newFromXml
     * @covers \BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult\ProductCode::newFromXml
     * @covers \BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult\ProductCode::getScheme
     * @covers \BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult\ProductCode::getCode
     * @covers \BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult\Product::getData
     * @covers \BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult\Product::getIdentity
     * @covers \BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult\Product::setIdentity
     * @covers \BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult\Product::setData
     * @covers \BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult\Data::newFromXml
     * @covers \BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult\Data::getLanguages
     * @covers \BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult\Data::addLanguage
     * @covers \BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult\Language::getCode
     * @covers \BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult\DataLanguage::newFromXml
     * @covers \BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult\DataLanguage::getCode
     * @covers \BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult\DataLanguage::setCode
     * @covers \BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult\DataLanguage::getItemTypeGroups
     * @covers \BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult\DataLanguage::addItemTypeGroup
     * @covers \BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult\ItemTypeGroup::newFromXml
     * @covers \BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult\ItemTypeGroup::getId
     * @covers \BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult\ItemTypeGroup::setId
     * @covers \BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult\ItemTypeGroup::getItems
     * @covers \BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult\ItemTypeGroup::addItem
     * @covers \BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult\AbstractItem::newFromXml
     * @covers \BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult\AbstractItem::getName
     * @covers \BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult\AbstractItem::newFromXmlFactory
     * @covers \BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult\NameTextItems::newFromXml
     * @covers \BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult\NameTextItems::getName
     * @covers \BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult\NameTextItems::addNameText
     * @covers \BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult\NameTextItems::getNameTexts
     * @covers \BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult\NameText::newFromXml
     * @covers \BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult\NameText::getName
     * @covers \BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult\NameText::setName
     * @covers \BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult\NameText::getText
     * @covers \BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult\NameText::setText
     */
    public function testGetMessage()
    {
        $this->assertTrue(true, $this->object->getMessage()->hasProducts());

        $product = $this->object->getMessage()->getProducts()[0];

        $this->assertTrue(true, $product->getIdentity()->hasProductCodes());
        $this->assertTrue(true, $product->getIdentity()->hasTargetMarkets());
        $this->assertEquals('3272770099486', $product->getIdentity()->getProductCodes(function (ProductCode $pc) { return $pc->getScheme() === 'GTIN'; })[0]->getCode());

        $this->assertEquals(
            82,
            $product
                ->getData()
                ->getLanguages(function (DataLanguage $o) {  return (string)$o->getCode() === 'en-GB'; })[0]
                ->getItemTypeGroups(function (ItemTypeGroup $o) { return $o->getId() === 0; })[0]
                ->getItems(function (AbstractItem $o) { return $o->getName() === 'Unit Merchandising' and $o instanceof NameTextItems; })[0]
                ->getNameTexts(function (NameText $o) { return $o->getName() === 'Depth'; })[0]
                ->getText()
        );
    }
}
