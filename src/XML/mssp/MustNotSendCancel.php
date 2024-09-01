<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\mssp;

use SimpleSAML\WSSecurity\Constants as C;
use SimpleSAML\WSSecurity\XML\sp\AbstractQNameAssertionType;

/**
 * An MustNotSendCancel element
 *
 * @package simplesamlphp/ws-security
 */
final class MustNotSendCancel extends AbstractQNameAssertionType
{
    /** @var string */
    public const NS = C::NS_WS_SEC;

    /** @var string */
    public const NS_PREFIX = 'mssp';
}
