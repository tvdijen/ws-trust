<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\sp_200507;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\sp_200507\AbstractQNameAssertionType;
use SimpleSAML\WSSecurity\XML\sp_200507\AbstractSpElement;
use SimpleSAML\WSSecurity\XML\sp_200507\InclusiveC14N;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\sp_200507\InclusiveC14NTest
 *
 * @package simplesamlphp/ws-security
 */
#[Group('sp')]
#[CoversClass(InclusiveC14N::class)]
#[CoversClass(AbstractQNameAssertionType::class)]
#[CoversClass(AbstractSpElement::class)]
final class InclusiveC14NTest extends TestCase
{
    use QNameAssertionTypeTestTrait;
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = InclusiveC14N::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/sp/200507/InclusiveC14N.xml',
        );
    }
}
