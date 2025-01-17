<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsp;

use DOMElement;
use SimpleSAML\WSSecurity\Assert\Assert;
use SimpleSAML\WSSecurity\Constants as C;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};
use SimpleSAML\XML\XsNamespace as NS;

/**
 * Class defining the Policy element
 *
 * @package simplesamlphp/ws-security
 */
final class Policy extends AbstractOperatorContentType implements SchemaValidatableElementInterface
{
    use ExtendableAttributesTrait;
    use SchemaValidatableElementTrait;

    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = NS::ANY;


    /**
     * Initialize a wsp:Policy
     *
     * @param string|null $Name
     * @param \SimpleSAML\XML\Attribute|null $Id
     * @param (\SimpleSAML\WSSecurity\XML\wsp\All|
     *         \SimpleSAML\WSSecurity\XML\wsp\ExactlyOne|
     *         \SimpleSAML\WSSecurity\XML\wsp\Policy|
     *         \SimpleSAML\WSSecurity\XML\wsp\PolicyReference)[] $operatorContent
     * @param \SimpleSAML\XML\Chunk[] $children
     * @param \SimpleSAML\XML\Attribute[] $namespacedAttributes
     */
    public function __construct(
        protected ?string $Name = null,
        protected ?XMLAttribute $Id = null,
        array $operatorContent = [],
        array $children = [],
        array $namespacedAttributes = [],
    ) {
        Assert::nullOrValidURI($Name, SchemaViolationException::class);
        if ($Id !== null) {
            Assert::validNCName($Id->getAttrValue(), SchemaViolationException::class);
        }

        $this->setAttributesNS($namespacedAttributes);

        parent::__construct($operatorContent, $children);
    }


    /**
     * @return \SimpleSAML\XML\Attribute|null
     */
    public function getId(): ?XMLAttribute
    {
        return $this->Id;
    }


    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->Name;
    }


    /**
     * Test if an object, at the state it's in, would produce an empty XML-element
     *
     * @return bool
     */
    final public function isEmptyElement(): bool
    {
        return empty($this->getName())
            && empty($this->getId())
            && empty($this->getAttributesNS())
            && parent::isEmptyElement();
    }


    /*
     * Convert XML into an wsp:Policy element
     *
     * @param \DOMElement $xml The XML element we should load
     * @return static
     *
     * @throws \SimpleSAML\XML\Exception\InvalidDOMElementException
     *   If the qualified name of the supplied element is wrong
     */
    #[\Override]
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, static::getLocalName(), InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, static::NS, InvalidDOMElementException::class);

        $Id = null;
        if ($xml->hasAttributeNS(C::NS_SEC_UTIL, 'Id')) {
            $Id = new XMLAttribute(C::NS_SEC_UTIL, 'wsu', 'Id', $xml->getAttributeNS(C::NS_SEC_UTIL, 'Id'));
        }

        $namespacedAttributes = self::getAttributesNSFromXML($xml);
        foreach ($namespacedAttributes as $i => $attr) {
            if ($attr->getNamespaceURI() === null) {
                if ($attr->getAttrName() === 'Name') {
                    unset($namespacedAttributes[$i]);
                    break;
                }
            } elseif ($attr->getNamespaceURI() === C::NS_SEC_UTIL) {
                if ($attr->getAttrName() === 'Id') {
                    unset($namespacedAttributes[$i]);
                    break;
                }
            }
        }

        $operatorContent = $children = [];
        for ($n = $xml->firstChild; $n !== null; $n = $n->nextSibling) {
            if (!($n instanceof DOMElement)) {
                continue;
            } elseif ($n->namespaceURI !== self::NS) {
                $children[] = new Chunk($n);
                continue;
            }

            $operatorContent[] = match ($n->localName) {
                'All' => All::fromXML($n),
                'ExactlyOne' => ExactlyOne::fromXML($n),
                'Policy' => Policy::fromXML($n),
                'PolicyReference' => PolicyReference::fromXML($n),
                default => null,
            };
        }

        return new static(
            self::getOptionalAttribute($xml, 'Name', null),
            $Id,
            $operatorContent,
            $children,
            $namespacedAttributes,
        );
    }


    /**
     * Convert this wsp:Policy to XML.
     *
     * @param \DOMElement|null $parent The element we should add this wsp:Policy to
     * @return \DOMElement This wsp:Policy element.
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::toXML($parent);

        if ($this->getName() !== null) {
            $e->setAttribute('Name', $this->getName());
        }

        $this->getId()?->toXML($e);

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        return $e;
    }
}
