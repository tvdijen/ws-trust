<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wst_200502;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP\Constants as SOAP;
use SimpleSAML\Test\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\wsa_200408\AbstractEndpointReferenceType;
use SimpleSAML\WSSecurity\XML\wsa_200408\MessageID;
use SimpleSAML\WSSecurity\XML\wst_200502\AbstractWstElement;
use SimpleSAML\WSSecurity\XML\wst_200502\IssuedTokens;
use SimpleSAML\WSSecurity\XML\wst_200502\RequestSecurityTokenResponse;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;

/**
 * Class \SimpleSAML\WSSecurity\XML\wst_200502\IssuedTokensTest
 *
 * @package simplesamlphp/ws-security
 */
#[Group('wst')]
#[CoversClass(IssuedTokens::class)]
#[CoversClass(AbstractEndpointReferenceType::class)]
#[CoversClass(AbstractWstElement::class)]
final class IssuedTokensTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/ws-trust-200502.xsd';

        self::$testedClass = IssuedTokens::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wst/200502/IssuedTokens.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a IssuedTokens object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new XMLAttribute(SOAP::NS_SOAP_ENV_11, 'soapenv', 'mustUnderstand', '1');
        $attr2 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'testval1');
        $attr3 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr2', 'testval2');
        $msgId = new MessageID('uuid:d0ccf3cd-2dce-4c1a-a5d6-be8912ecd7de', [$attr1]);

        $requestSecurityTokenResponse = new RequestSecurityTokenResponse(C::NAMESPACE, [$msgId], [$attr2]);

        $issuedTokens = new IssuedTokens(
            [$requestSecurityTokenResponse],
            [$attr3],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($issuedTokens),
        );
    }
}
