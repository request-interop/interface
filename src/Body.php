<?php
declare(strict_types=1);

namespace RequestInterop\Interface;

use Stringable;

/**
 * @phpstan-type BodyResource resource
 */
interface Body extends Stringable
{
    /** @var ?BodyResource */
    public mixed $body { get; }

    public function __toString() : string;
}
