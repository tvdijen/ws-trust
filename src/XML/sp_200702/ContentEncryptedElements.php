<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\sp_200702;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * An ContentEncryptedElements element
 *
 * @package simplesamlphp/ws-security
 */
final class ContentEncryptedElements extends AbstractSerElementsType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
