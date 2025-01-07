<?php
declare(strict_types=1);

namespace RequestInterop\Interface;

/**
 * @phpstan-import-type HttpUploadErrorCode from Request
 */
interface Upload
{
    /** @var non-empty-string */
    public string $tmpName { get; }

    /** @var HttpUploadErrorCode */
    public int $error { get; }

    /** @var non-empty-string|null */
    public ?string $name { get; }

    /** @var non-empty-string|null */
    public ?string $fullPath { get; }

    /** @var non-empty-string|null */
    public ?string $type { get; }

    /** @var positive-int|null */
    public ?int $size { get; }

    /**
     * @param non-empty-string $to
     * @throws UploadException
     */
    public function move(string $to): bool;

    /**
     * @throws StreamException
     */
    public function getStream(): Stream;
}
