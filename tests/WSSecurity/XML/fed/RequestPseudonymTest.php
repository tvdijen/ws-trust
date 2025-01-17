<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\fed;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\fed\AbstractFedElement;
use SimpleSAML\WSSecurity\XML\fed\AbstractRequestPseudonymType;
use SimpleSAML\WSSecurity\XML\fed\RequestPseudonym;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for fed:RequestPseudonym.
 *
 * @package simplesamlphp/ws-security
 */
#[Group('fed')]
#[CoversClass(RequestPseudonym::class)]
#[CoversClass(AbstractRequestPseudonymType::class)]
#[CoversClass(AbstractFedElement::class)]
final class RequestPseudonymTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = RequestPseudonym::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/fed_RequestPseudonym.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a RequestPseudonym object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', 'testval1');
        $child = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">SomeChunk</ssp:Chunk>',
        );

        $requestPseudonym = new RequestPseudonym(
            true,
            false,
            [new Chunk($child->documentElement)],
            [$attr1],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($requestPseudonym),
        );
    }


    /**
     */
    public function testMarshallingEmpty(): void
    {
        $requestPseudonym = new RequestPseudonym();
        $this->assertTrue($requestPseudonym->isEmptyElement());
    }
}
