<?php
declare(strict_types=1);

namespace RequestInterop\Interface;

/**
 * @phpstan-import-type BodyResource from Body
 * @phpstan-import-type CookiesArray from Request
 * @phpstan-import-type FilesArray from Request
 * @phpstan-import-type FilesArrayItem from Request
 * @phpstan-import-type FilesArrayGroup from Request
 * @phpstan-import-type HeadersArray from Request
 * @phpstan-import-type InputArray from Request
 * @phpstan-import-type MethodString from Request
 * @phpstan-import-type QueryArray from Request
 * @phpstan-import-type ServerArray from Request
 * @phpstan-import-type UploadsArray from Request
 */
interface Factory
{
    /**
     * @param ?CookiesArray $cookies
     * @param ?FilesArray $files
     * @param ?HeadersArray $headers
     * @param ?InputArray $input
     * @param ?InputArray $input
     * @param ?MethodString $method
     * @param ?QueryArray $query
     * @param ?ServerArray $server
     * @param ?UploadsArray $uploads
     * @param ?BodyResource $body
     * @return Request|(Request&Body)
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
        ?Url $url = null,
        mixed $body = null,
    ) : Request;

    /**
     * @param ?BodyResource $body
     * @return Upload|(Upload&Body)
     */
    public function newUpload(
        string $tmpName,
        int $error,
        ?string $name = null,
        ?string $fullPath = null,
        ?string $type = null,
        ?int $size = null,
        mixed $body = null,
    ) : Upload;

    public function newUrl(
        ?string $scheme = null,
        ?string $host = null,
        ?int $port = null,
        ?string $user = null,
        ?string $pass = null,
        ?string $path = null,
        ?string $query = null,
        ?string $fragment = null,
    ) : Url;
}
