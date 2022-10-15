<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\Exception\TooManyElementsException;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\WSSecurity\XML\ReferenceIdentifierTrait;

use function array_pop;

/**
 * @package tvdijen/ws-security
 */
final class Choice extends AbstractWstElement
{
    use ExtendableAttributesTrait;
    use ReferenceIdentifierTrait;

    /** @var string|null */
    protected ?string $label;

    /** @var \SimpleSAML\WSSecurity\XML\wst\Image|null */
    protected ?Image $image;


    /**
     * Initialize a wst:Choice
     *
     * @param string $refId
     * @param string|null $label
     * @param \SimpleSAML\WSSecurity\XML\wst\Image|null $image
     * @param \DOMAttr[] $namespacedAttributes
     */
    public function __construct(
        string $refId,
        ?string $label = null,
        ?Image $image = null,
        array $namespacedAttributes = []
    ) {
        $this->setRefId($refId);
        $this->setLabel($label);
        $this->setImage($image);
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * Collect the value of the label property.
     *
     * @return string|null
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }


    /**
     * Set the value of the label property.
     *
     * @param string|null $label
     */
    protected function setLabel(?string $label): void
    {
        $this->label = $label;
    }


    /**
     * Collect the value of the image property.
     *
     * @return \SimpleSAML\WSSecurity\XML\wst\Image|null
     */
    public function getImage(): ?Image
    {
        return $this->image;
    }


    /**
     * Set the value of the image property.
     *
     * @param \SimpleSAML\WSSecurity\XML\wst\Image|null $image
     */
    protected function setImage(?Image $image): void
    {
        $this->image = $image;
    }


    /**
     * Convert XML into a wst:Choice
     *
     * @param \DOMElement $xml The XML element we should load
     * @return static
     *
     * @throws \SimpleSAML\XML\Exception\InvalidDOMElementException
     *   If the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, 'Choice', InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, Choice::NS, InvalidDOMElementException::class);

        /** @psalm-var string $refId */
        $refId = self::getAttribute($xml, 'RefId');
        $label = self::getAttribute($xml, 'Label', null);

        $image = Image::getChildrenOfClass($xml);
        Assert::maxCount($image, 1, TooManyElementsException::class);

        return new static($refId, $label, array_pop($image), self::getAttributesNSFromXML($xml));
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
        $e->setAttribute('RefId', $this->refId);

        if ($this->label !== null) {
            $e->setAttribute('Label', $this->label);
        }

        if ($this->image !== null) {
            $this->image->toXML($e);
        }

        foreach ($this->getAttributesNS() as $attr) {
            $e->setAttributeNS($attr['namespaceURI'], $attr['qualifiedName'], $attr['value']);
        }

        return $e;
    }
}