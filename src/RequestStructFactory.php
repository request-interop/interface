<?php
declare(strict_types=1);

namespace RequestInterop\Interface;

use StreamInterop\Interface\StringableStream;
use UploadInterop\Interface\UploadTypeAliases;
use UriInterop\Interface\UriStruct;

/**
 * @phpstan-import-type request_body_array from RequestTypeAliases
 *
 * @phpstan-import-type request_cookies_array from RequestTypeAliases
 *
 * @phpstan-import-type request_headers_array from RequestTypeAliases
 *
 * @phpstan-import-type request_method_string from RequestTypeAliases
 *
 * @phpstan-import-type request_query_array from RequestTypeAliases
 *
 * @phpstan-import-type request_server_array from RequestTypeAliases
 *
 * @phpstan-import-type uploads_array from UploadTypeAliases
 */
interface RequestStructFactory
{
    /**
     * @param ?request_cookies_array $cookies
     * @param ?request_headers_array $headers
     * @param ?request_body_array $body
     * @param ?request_method_string $method
     * @param ?request_query_array $query
     * @param ?request_server_array $server
     * @param ?uploads_array $uploads
     */
    public function newRequest(
        ?array $body = null,
        ?array $cookies = null,
        ?array $headers = null,
        ?StringableStream $input = null,
        ?string $method = null,
        ?array $query = null,
        ?array $server = null,
        ?array $uploads = null,
        ?UriStruct $uri = null,
    ) : RequestStruct;
}
