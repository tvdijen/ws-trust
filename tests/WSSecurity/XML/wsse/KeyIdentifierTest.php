<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsse;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\wsse\AbstractAttributedString;
use SimpleSAML\WSSecurity\XML\wsse\AbstractEncodedString;
use SimpleSAML\WSSecurity\XML\wsse\AbstractKeyIdentifierType;
use SimpleSAML\WSSecurity\XML\wsse\AbstractWsseElement;
use SimpleSAML\WSSecurity\XML\wsse\KeyIdentifier;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for wsse:KeyIdentifier.
 *
 * @package simplesamlphp/ws-security
 */
#[Group('wsse')]
#[CoversClass(KeyIdentifier::class)]
#[CoversClass(AbstractKeyIdentifierType::class)]
#[CoversClass(AbstractEncodedString::class)]
#[CoversClass(AbstractAttributedString::class)]
#[CoversClass(AbstractWsseElement::class)]
final class KeyIdentifierTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = KeyIdentifier::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsse_KeyIdentifier.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a KeyIdentifier object from scratch.
     */
    public function testMarshalling(): void
    {
        $content = 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=';
        $attr1 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', 'testval1');

        $keyIdentifier = new KeyIdentifier(
            $content,
            'http://schemas.microsoft.com/5.0.0.0/ConfigurationManager/Enrollment/DeviceEnrollmentUserToken',
            'SomeID',
            'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd#base64binary',
            [$attr1],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($keyIdentifier),
        );
    }
}
