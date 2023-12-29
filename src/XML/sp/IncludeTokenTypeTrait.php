<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\sp;

use DOMElement;
use SimpleSAML\Assert\Assert;

use function array_pop;

/**
 * Trait grouping common functionality for elements that can hold IncludeToken attributes.
 *
 * @package tvdijen/ws-security
 */
trait IncludeTokenTypeTrait
{
    /**
     * The included token.
     *
     * @var \SimpleSAML\WSSecurity\XML\sp\IncludeToken|string|null
     */
    protected IncludeToken|string|null $includeToken;


    /**
     * Collect the value of the includeToken-property
     *
     * @return \SimpleSAML\WSSecurity\XML\sp\IncludeToken|string|null
     */
    public function getIncludeToken(): IncludeToken|string|null
    {
        return $this->includeToken;
    }


    /**
     * Set the value of the includeToken-property
     *
     * @param \SimpleSAML\WSSecurity\XML\sp\IncludeToken|string|null $includeToken
     */
    protected function setIncludeToken(IncludeToken|string|null $includeToken): void
    {
        if (is_string($includeToken)) {
            Assert::validURI($includeToken);
        }

        $this->includeToken = $includeToken;
    }
}
