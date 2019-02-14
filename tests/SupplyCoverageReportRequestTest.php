<?php

use BrandbankSOAPAPIClient\Request\SupplyCoverageReport\Item;
use BrandbankSOAPAPIClient\Request\SupplyCoverageReport\Message;
use BrandbankSOAPAPIClient\Request\SupplyCoverageReport\RetailerFeedbackReport;
use BrandbankSOAPAPIClient\Request\SupplyCoverageReport\SupplyCoverageReport;
use BrandbankSOAPAPIClient\Request\SupplyCoverageReport\xmlData;
use BrandbankSOAPAPIClient\Request\SupplyCoverageReportRequest;
use PHPUnit\Framework\TestCase;

final class SupplyCoverageReportRequestTest extends TestCase
{
    /** @var SupplyCoverageReportRequest */
    protected $object;

    protected function setUp()
    {
        parent::setUp();

        $this->object = new SupplyCoverageReportRequest(
            new SupplyCoverageReport(
                new xmlData(
                    (
                    new RetailerFeedbackReport(
                        new Message(new DateTime('2007-09-20T00:13:05.030+00:00'))
                    )
                    )
                        ->addItem(
                            new Item('3272770099486')
                        )
                )
            )
        );
    }

    protected function getExpectedXml(): string
    {
        $xml = simplexml_load_string(
            '<RetailerFeedbackReport xmlns="http://www.brandbank.com/schemas/CoverageFeedback/2005/11">
                      <Message DateTime="2007-09-20T00:13:05.030+00:00" Domain="LST" />
                      <Item HasLabelData="true" HasImage="true">
                        <RetailerID>3272770099486</RetailerID>
                        <Description>UNKNOWN</Description>
                        <GTINs>
                          <GTIN Value="3272770099486">
                            <Suppliers>
                              <Supplier>
                                <SupplierName>UNKNOWN</SupplierName>
                              </Supplier>
                            </Suppliers>
                          </GTIN>
                        </GTINs>
                        <OwnLabel>false</OwnLabel>
                        <Categories>
                            <Category>UNKNOWN</Category>
                        </Categories>
                      </Item>
                    </RetailerFeedbackReport>'
        );

        return $xml->asXML();
    }

    /**
     * @covers SupplyCoverageReportRequest::getSupplyCoverageReport
     * @covers SupplyCoverageReportRequest::setSupplyCoverageReport
     * @covers SupplyCoverageReportRequest::toArray
     */
    public function testToArray()
    {
        $objectArray = $this->object->toArray();

        /**
         * @expected array = [
         * 'SupplyCoverageReport' => [
         * 'xmlData' => [
         * 'any' => $this->getXml()
         * ]
         * ]
         * ];
         */
        $this->assertTrue(array_key_exists('SupplyCoverageReport', $objectArray));
        $this->assertTrue(array_key_exists('xmlData', $objectArray['SupplyCoverageReport']));
        $this->assertTrue(array_key_exists('any', $objectArray['SupplyCoverageReport']['xmlData']));

        $this->assertXmlStringEqualsXmlString($this->getExpectedXml(), $this->object->getSupplyCoverageReport()->getXmlData()->getRetailerFeedbackReport()->toXml()->asXML());
    }

    /**
     * @covers SupplyCoverageReportRequest::getSupplyCoverageReport
     * @covers SupplyCoverageReportRequest::setSupplyCoverageReport
     * @covers RetailerFeedbackReport::toXml
     * @covers XmlData::getRetailerFeedbackReport
     * @covers SupplyCoverageReport::getXmlData
     */
    public function testXSDValidate()
    {
        $xml = new DOMDocument();
        $xml->loadXML($this->object->getSupplyCoverageReport()->getXmlData()->getRetailerFeedbackReport()->toXml()->asXML());

        $this->assertTrue($xml->schemaValidate(__DIR__ . '/xsd/SupplyCoverageReport/CoverageReportv2a.xsd'));
    }
}
