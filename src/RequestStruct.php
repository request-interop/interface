<?php
declare(strict_types=1);

namespace RequestInterop\Interface;

use StreamInterop\Interface\StringableStream;
use UploadInterop\Interface\UploadTypeAliases;
use UriInterop\Interface\UriStruct;

/**
 * @phpstan-import-type request_cookies_array from RequestTypeAliases
 *
 * @phpstan-import-type request_headers_array from RequestTypeAliases
 *
 * @phpstan-import-type request_body_array from RequestTypeAliases
 *
 * @phpstan-import-type request_method_string from RequestTypeAliases
 *
 * @phpstan-import-type request_query_array from RequestTypeAliases
 *
 * @phpstan-import-type request_server_array from RequestTypeAliases
 *
 * @phpstan-import-type upload_structs_array from UploadTypeAliases
 */
interface RequestStruct
{
    public StringableStream $input { get; }

    /** @var request_cookies_array */
    public array $cookies { get; }

    /** @var request_headers_array */
    public array $headers { get; }

    /** @var request_body_array */
    public array $body { get; }

    /** @var request_method_string */
    public string $method { get; }

    /** @var request_query_array */
    public array $query { get; }

    /** @var request_server_array */
    public array $server { get; }

    /** @var upload_structs_array */
    public array $uploads { get; }

    public UriStruct $uri { get; }
}
