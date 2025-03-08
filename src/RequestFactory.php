<?php
declare(strict_types=1);

namespace RequestInterop\Interface;

/**
 * @phpstan-import-type cookies_array from RequestTypeAliases
 * @phpstan-import-type files_array from RequestTypeAliases
 * @phpstan-import-type headers_array from RequestTypeAliases
 * @phpstan-import-type input_array from RequestTypeAliases
 * @phpstan-import-type method_string from RequestTypeAliases
 * @phpstan-import-type query_array from RequestTypeAliases
 * @phpstan-import-type server_array from RequestTypeAliases
 * @phpstan-import-type uploads_array from RequestTypeAliases
 */
interface RequestFactory
{
    /**
     * @param ?cookies_array $cookies
     * @param ?files_array $files
     * @param ?headers_array $headers
     * @param ?input_array $input
     * @param ?method_string $method
     * @param ?query_array $query
     * @param ?server_array $server
     * @param ?uploads_array $uploads
     */
    public function newRequest(
        ?array $cookies = null,
        ?array $files = null,
        ?array $headers = null,
        ?array $input = null,
        ?string $method = null,
        ?array $query = null,
        ?array $server = null,
        ?array $uploads = null,
        ?RequestUrl $url = null,
        ?RequestBody $body = null,
    ) : Request;

    public function newRequestUpload(
        string $tmpName,
        int $error,
        ?string $name = null,
        ?string $fullPath = null,
        ?string $type = null,
        ?int $size = null,
        ?RequestBody $body = null,
    ) : RequestUpload;

    /**
     * @param string|resource $spec
     */
    public function newRequestBody(mixed $spec) : ?RequestBody;

    /**
     * @param server_array $server
     */
    public function newRequestUrl(array $server) : RequestUrl;
}
