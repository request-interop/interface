<?php
declare(strict_types=1);

namespace RequestInterop\Interface;

use StreamInterop\Interface\StringableStream;
use UploadInterop\Interface\UploadTypeAliases;
use UriInterop\Interface\UriStruct;

/**
 * @phpstan-import-type cookies_array from RequestTypeAliases
 *
 * @phpstan-import-type files_array from UploadTypeAliases
 *
 * @phpstan-import-type headers_array from RequestTypeAliases
 *
 * @phpstan-import-type input_array from RequestTypeAliases
 *
 * @phpstan-import-type method_string from RequestTypeAliases
 *
 * @phpstan-import-type query_array from RequestTypeAliases
 *
 * @phpstan-import-type server_array from RequestTypeAliases
 *
 * @phpstan-import-type uploads_array from UploadTypeAliases
 */
interface RequestStruct
{
    public StringableStream $body { get; }

    /** @var cookies_array */
    public array $cookies { get; }

    /** @var files_array */
    public array $files { get; }

    /** @var headers_array */
    public array $headers { get; }

    /** @var input_array */
    public array $input { get; }

    /** @var method_string */
    public string $method { get; }

    /** @var query_array */
    public array $query { get; }

    /** @var server_array */
    public array $server { get; }

    /** @var uploads_array */
    public array $uploads { get; }

    public UriStruct $uri { get; }
}
