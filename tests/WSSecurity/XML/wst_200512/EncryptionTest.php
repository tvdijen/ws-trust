<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wst_200512;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP\Constants as SOAP;
use SimpleSAML\WSSecurity\XML\wsa_200508\MessageID;
use SimpleSAML\WSSecurity\XML\wst_200512\AbstractEncryptionType;
use SimpleSAML\WSSecurity\XML\wst_200512\AbstractWstElement;
use SimpleSAML\WSSecurity\XML\wst_200512\Encryption;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\wst_200512\EncryptionTest
 *
 * @package simplesamlphp/ws-security
 */
#[Group('wst')]
#[CoversClass(Encryption::class)]
#[CoversClass(AbstractEncryptionType::class)]
#[CoversClass(AbstractWstElement::class)]
final class EncryptionTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Encryption::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wst/200512/Encryption.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a Encryption object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new XMLAttribute(SOAP::NS_SOAP_ENV_11, 'soapenv', 'mustUnderstand', '1');
        $msgId = new MessageID('uuid:d0ccf3cd-2dce-4c1a-a5d6-be8912ecd7de', [$attr1]);

        $encryption = new Encryption($msgId);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($encryption),
        );
    }
}
