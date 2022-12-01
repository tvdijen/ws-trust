<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\WSSecurity\XML\ReferenceIdentifierTrait;

/**
 * @package tvdijen/ws-security
 */
final class ChoiceSelected extends AbstractWstElement
{
    use ReferenceIdentifierTrait;


    /**
     * Initialize a wst:ChoiceSelected
     *
     * @param string $refId
     */
    public function __construct(string $refId)
    {
        $this->setRefId($refId);
    }


    /**
     * Convert XML into a wst:ChoiceSelected
     *
     * @param \DOMElement $xml The XML element we should load
     * @return static
     *
     * @throws \SimpleSAML\XML\Exception\InvalidDOMElementException
     *   If the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, 'ChoiceSelected', InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, ChoiceSelected::NS, InvalidDOMElementException::class);

        /** @psalm-var string $refId */
        $refId = self::getAttribute($xml, 'RefId');

        return new static($refId);
    }


    /**
     * Convert this element to XML.
     *
     * @param \DOMElement|null $parent The element we should append this element to.
     * @return \DOMElement
     */
    public function toXML(DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);
        $e->setAttribute('RefId', $this->getRefId());

        return $e;
    }
}
