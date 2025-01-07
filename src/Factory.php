<?php
declare(strict_types=1);

namespace RequestInterop\Interface;

/**
 * @phpstan-import-type CookiesArray from Request
 * @phpstan-import-type FilesArray from Request
 * @phpstan-import-type HeadersArray from Request
 * @phpstan-import-type InputArray from Request
 * @phpstan-import-type HttpMethod from Request
 * @phpstan-import-type QueryArray from Request
 * @phpstan-import-type ServerArray from Request
 * @phpstan-import-type UploadsArray from Request
 * @phpstan-import-type HttpUploadErrorCode from Request
 */
interface Factory
{
    /**
     * @param ?CookiesArray $cookies
     * @param ?FilesArray $files
     * @param ?HeadersArray $headers
     * @param ?InputArray $input
     * @param ?HttpMethod $method
     * @param ?QueryArray $query
     * @param ?ServerArray $server
     * @param ?UploadsArray $uploads
     * @return Request|(Request&Body)
     * @throws FactoryException
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
     * @param non-empty-string $tmpName
     * @param HttpUploadErrorCode $error
     * @param non-empty-string|null $name
     * @param non-empty-string|null $fullPath
     * @param non-empty-string|null $type
     * @param positive-int|null $size
     * @return Upload|(Upload&Body)
     * @throws FactoryException
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

    /**
     * @param HttpScheme|null $scheme
     * @param non-empty-string|null $host
     * @param NetworkPort|null $port
     * @param non-empty-string|null $user
     * @param non-empty-string|null $pass
     * @param non-empty-string|null $path
     * @param non-empty-string|null $query
     * @param non-empty-string|null $fragment
     * @throws FactoryException
     */
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

    /**
     * @param BodyResource $body
     */
    public function newBody(mixed $body) : Body;
}
