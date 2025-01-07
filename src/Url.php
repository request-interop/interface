<?php
declare(strict_types=1);

namespace RequestInterop\Interface;

use Stringable;

/**
 * @phpstan-type NetworkPort int<1, 65535>
 * @phpstan-type HttpScheme 'http'|'https'
 * @phpstan-type UrlArray array{
 *     scheme: HttpScheme|null,
 *     user: non-empty-string|null,
 *     pass: non-empty-string|null,
 *     host: non-empty-string|null,
 *     port: NetworkPort|null,
 *     path: non-empty-string|null,
 *     query: non-empty-string|null,
 *     fragment: non-empty-string|null
 * }
 */
interface Url extends Stringable
{
    /** @var HttpScheme|null */
    public ?string $scheme { get; }

    /** @var non-empty-string|null */
    public ?string $host { get; }

    /** @var NetworkPort|null */
    public ?int $port { get; }

    /** @var non-empty-string|null */
    public ?string $user { get; }

    /** @var non-empty-string|null */
    public ?string $pass { get; }

    /** @var non-empty-string|null */
    public ?string $path { get; }

    /** @var non-empty-string|null */
    public ?string $query { get; }

    /** @var non-empty-string|null */
    public ?string $fragment { get; }

    /** @return non-empty-string */
    public function __toString() : string;
}
