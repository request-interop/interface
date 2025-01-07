<?php
declare(strict_types=1);

namespace RequestInterop\Interface;

use Stringable;

/**
 * @phpstan-type StreamPosition int<0, max>
 * @phpstan-type StreamWhence SEEK_SET|SEEK_CUR|SEEK_END
 * @phpstan-type StreamLength positive-int
 * @phpstan-type StreamContent non-empty-string
 */
interface Stream extends Stringable
{
    /**
     * @return StreamPosition
     * @throws StreamException
     */
    public function tell(): int;

    /**
     * @param StreamLength $length
     * @return StreamContent
     * @throws StreamException
     */
    public function read(int $length): string;

    /**
     * @param StreamPosition $offset
     * @param StreamWhence $whence
     * @throws StreamException
     */
    public function seek(int $offset, int $whence = SEEK_SET): void;

    public function eof(): bool;

    /**
     * @return StreamContent
     * @throws StreamException
     */
    public function __toString(): string;
}
