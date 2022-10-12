<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wst;

use DOMDocument;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Assert\AssertionFailedException;
use SimpleSAML\Test\XML\SerializableElementTestTrait;
use SimpleSAML\WSSecurity\Constants;
use SimpleSAML\WSSecurity\XML\wst\ChoiceSelected;
use SimpleSAML\XML\DOMDocumentFactory;

use function dirname;
use function strval;

/**
 * Tests for wst:ChoiceSelected.
 *
 * @covers \SimpleSAML\WSSecurity\XML\wst\ChoiceSelected
 * @covers \SimpleSAML\WSSecurity\XML\wst\AbstractWstElement
 * @package tvdijen/ws-security
 */
final class ChoiceSelectedTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    protected function setUp(): void
    {
        $this->testedClass = ChoiceSelected::class;

        $this->xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(dirname(dirname(dirname(__FILE__)))) . '/resources/xml/wst_ChoiceSelected.xml'
        );
    }


    // test marshalling


    /**
     * Test creating an ChoiceSelected object from scratch.
     */
    public function testMarshalling(): void
    {
        $choiceSelected = new ChoiceSelected('urn:x-simplesamlphp:namespace');

        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($choiceSelected)
        );
    }


    // test unmarshalling


    /**
     * Test creating a ChoiceSelected from XML.
     */
    public function testUnmarshalling(): void
    {
        $choiceSelected = ChoiceSelected::fromXML($this->xmlRepresentation->documentElement);
        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($choiceSelected)
        );
    }
}