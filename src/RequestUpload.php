<?php
declare(strict_types=1);

namespace RequestInterop\Interface;

use Stringable;

interface RequestUpload
{
    public string $tmpName { get; }

    public int $error { get; }

    public ?string $name { get; }

    public ?string $fullPath { get; }

    public ?string $type { get; }

    public ?int $size { get; }

    public ?RequestBody $body { get; }

    public function move(string|Stringable $to) : bool;
}
