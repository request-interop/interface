<?php
declare(strict_types=1);

namespace RequestInterop\Interface;

use StreamInterop\Interface\StringableStream;
use UploadInterop\Interface\UploadTypeAliases;
use UriInterop\Interface\UriStruct;

/**
 * @phpstan-import-type body_array from RequestTypeAliases
 *
 * @phpstan-import-type cookies_array from RequestTypeAliases
 *
 * @phpstan-import-type headers_array from RequestTypeAliases
 *
 * @phpstan-import-type method_string from RequestTypeAliases
 *
 * @phpstan-import-type query_array from RequestTypeAliases
 *
 * @phpstan-import-type server_array from RequestTypeAliases
 *
 * @phpstan-import-type uploads_array from UploadTypeAliases
 */
interface RequestStructFactory
{
    /**
     * @param ?cookies_array $cookies
     * @param ?headers_array $headers
     * @param ?body_array $body
     * @param ?method_string $method
     * @param ?query_array $query
     * @param ?server_array $server
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
