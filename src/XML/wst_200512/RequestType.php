<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200512;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * A RequestType element
 *
 * @package simplesamlphp/ws-security
 */
final class RequestType extends AbstractRequestTypeOpenEnum implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
