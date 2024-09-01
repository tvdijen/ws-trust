<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSSecurity\XML\wsdl;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSSecurity\XML\wsdl\AbstractBindingOperation;
use SimpleSAML\WSSecurity\XML\wsdl\AbstractDocumented;
use SimpleSAML\WSSecurity\XML\wsdl\AbstractExtensibleDocumented;
use SimpleSAML\WSSecurity\XML\wsdl\AbstractWsdlElement;
use SimpleSAML\WSSecurity\XML\wsdl\BindingOperation;
use SimpleSAML\WSSecurity\XML\wsdl\BindingOperationFault;
use SimpleSAML\WSSecurity\XML\wsdl\BindingOperationInput;
use SimpleSAML\WSSecurity\XML\wsdl\BindingOperationOutput;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for wsdl:BindingOperation.
 *
 * @package simplesamlphp/ws-security
 */
#[Group('wsdl')]
#[CoversClass(BindingOperation::class)]
#[CoversClass(AbstractBindingOperation::class)]
#[CoversClass(AbstractExtensibleDocumented::class)]
#[CoversClass(AbstractDocumented::class)]
#[CoversClass(AbstractWsdlElement::class)]
final class BindingOperationTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = BindingOperation::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsdl_BindingOperation.xml',
        );
    }


    // test marshalling


    /**
     * Test creating an BindingOperation object from scratch.
     */
    public function testMarshalling(): void
    {
        $child = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">SomeChunk</ssp:Chunk>',
        );
        $inputChild = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">InputChunk</ssp:Chunk>',
        );
        $outputChild = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">OutputChunk</ssp:Chunk>',
        );
        $faultOneChild = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">FaultOneChunk</ssp:Chunk>',
        );
        $faultTwoChild = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">FaultTwoChunk</ssp:Chunk>',
        );

        $input = new BindingOperationInput('CustomInputName', [new Chunk($inputChild->documentElement)]);
        $output = new BindingOperationOutput('CustomOutputName', [new Chunk($outputChild->documentElement)]);
        $faultOne = new BindingOperationFault('CustomFaultOne', [new Chunk($faultOneChild->documentElement)]);
        $faultTwo = new BindingOperationFault('CustomFaultTwo', [new Chunk($faultTwoChild->documentElement)]);

        $bindingOperation = new BindingOperation(
            'SomeName',
            $input,
            $output,
            [$faultOne, $faultTwo],
            [new Chunk($child->documentElement)],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($bindingOperation),
        );
    }
}