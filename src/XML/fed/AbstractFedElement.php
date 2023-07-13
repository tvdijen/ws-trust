<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use SimpleSAML\XML\AbstractElement;
use SimpleSAML\WSSecurity\Constants as C;

/**
 * Abstract class to be implemented by all the classes in this namespace
 *
 * @see http://docs.oasis-open.org/wsfed/federation/v1.2/ws-federation.pdf
 * @package tvdijen/ws-security
 */
abstract class AbstractFedElement extends AbstractElement
{
    /** @var string */
    public const NS = C::NS_FED;

    /** @var string */
    public const NS_PREFIX = 'fed';
}