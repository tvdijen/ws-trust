<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\sp_200702;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * A SignedEncryptedSupportingTokens element
 *
 * @package simplesamlphp/ws-security
 */
final class SignedEncryptedSupportingTokens extends AbstractNestedPolicyType implements
    SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
