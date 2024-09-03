<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\sp_200702;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\sp_200702\AbstractQNameAssertionType;
use SimpleSAML\WSSecurity\XML\sp_200702\AbstractSpElement;
use SimpleSAML\WSSecurity\XML\sp_200702\MustNotSendRenew;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\sp_200702\MustNotSendRenewTest
 *
 * @package simplesamlphp/ws-security
 */
#[Group('sp')]
#[CoversClass(MustNotSendRenew::class)]
#[CoversClass(AbstractQNameAssertionType::class)]
#[CoversClass(AbstractSpElement::class)]
final class MustNotSendRenewTest extends TestCase
{
    use QNameAssertionTypeTestTrait;
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-securitypolicy-1.2.xsd';

        self::$testedClass = MustNotSendRenew::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/sp/200702/MustNotSendRenew.xml',
        );
    }
}