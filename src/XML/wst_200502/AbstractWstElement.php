<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wst_200502;

use SimpleSAML\WSSecurity\Constants as C;
use SimpleSAML\XML\AbstractElement;

/**
 * Abstract class to be implemented by all the classes in this namespace
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractWstElement extends AbstractElement
{
    /** @var string */
    public const NS = C::NS_TRUST_200502;

    /** @var string */
    public const NS_PREFIX = 't';

    /** @var string */
    public const SCHEMA = 'resources/schemas/ws-trust-200502.xsd';
}
