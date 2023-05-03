<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsa;

use DOMDocument;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Assert\AssertionFailedException;
use SimpleSAML\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\wsa\Action;
use SimpleSAML\WSSecurity\XML\wsa\ProblemAction;
use SimpleSAML\WSSecurity\XML\wsa\SoapAction;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for wsa:ProblemIRI.
 *
 * @covers \SimpleSAML\WSSecurity\XML\wsa\ProblemAction
 * @covers \SimpleSAML\WSSecurity\XML\wsa\AbstractProblemActionType
 * @covers \SimpleSAML\WSSecurity\XML\wsa\AbstractWsaElement
 * @package tvdijen/ws-security
 */
final class ProblemActionTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    protected function setUp(): void
    {
        $this->testedClass = ProblemAction::class;

        $this->schema = dirname(__FILE__, 5) . '/resources/schemas/ws-addr.xsd';

        $this->xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsa_ProblemAction.xml'
        );
    }


    // test marshalling


    /**
     * Test creating an ProblemAction object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = $this->xmlRepresentation->createAttributeNS('urn:x-simplesamlphp:namespace', 'ssp:test');
        $attr1->value = 'value';

        $problemAction = new ProblemAction(
            new Action('https://login.microsoftonline.com/login.srf', [$attr1]),
            new SoapAction('http://www.example.com/'),
            [$attr1]
        );

        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($problemAction)
        );
    }


    /**
     * Adding an empty ProblemAction element should yield an empty element.
     */
    public function testMarshallingEmptyElement(): void
    {
        $wsans = C::NS_ADDR;
        $problemAction = new ProblemAction();
        $this->assertEquals(
            "<wsa:ProblemAction xmlns:wsa=\"$wsans\"/>",
            strval($problemAction),
        );
        $this->assertTrue($problemAction->isEmptyElement());
    }


    // test unmarshalling


    /**
     * Test creating a ProblemAction from XML.
     */
    public function testUnmarshalling(): void
    {
        $problemAction = ProblemAction::fromXML($this->xmlRepresentation->documentElement);
        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($problemAction)
        );
    }
}