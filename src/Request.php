<?php
declare(strict_types=1);

namespace RequestInterop\Interface;

/**
 * @phpstan-type CookiesArray array<string, string>
 *
 * @phpstan-type FilesArrayValue FilesArrayItem|FilesArrayGroup|FilesArray
 * @phpstan-type FilesArray array<array-key, FilesArrayValue>
 *
 * @phpstan-type FilesArrayItem array{
 *     tmp_name: non-empty-string,
 *     error: HttpUploadErrorCode,
 *     name?: non-empty-string,
 *     full_path?: non-empty-string,
 *     type?: non-empty-string,
 *     size?: positive-int
 * }
 *
 * @phpstan-type FilesArrayGroup array{
 *     tmp_name: array<int, non-empty-string>,
 *     error: array<int, HttpUploadErrorCode>,
 *     name?: array<int, non-empty-string>,
 *     full_path?: array<int, non-empty-string>,
 *     type?: array<int, non-empty-string>,
 *     size?: array<int, positive-int>
 * }
 *
 * @phpstan-type HeadersArray array<lowercase-string, non-empty-string>
 *
 * @phpstan-type InputArrayValue null|scalar|InputArray
 * @phpstan-type InputArray array<array-key, InputArrayValue>
 *
 * @phpstan-type HttpMethod 'GET'|'POST'|'PUT'|'DELETE'|'HEAD'|'OPTIONS'|'PATCH'|'TRACE'|'CONNECT'
 *
 * @phpstan-type QueryArrayValue string|QueryArray
 * @phpstan-type QueryArray array<array-key, QueryArrayValue>
 *
 * @phpstan-type ServerArray array<non-empty-string, string>
 *
 * @phpstan-type UploadsArrayValue Upload|UploadsArray
 * @phpstan-type UploadsArray array<array-key, UploadsArrayValue>
 *
 * @phpstan-type HttpUploadErrorCode int<0, 8>
 */
interface Request
{
    /** @var CookiesArray */
    public array $cookies { get; }

    /** @var FilesArray */
    public array $files { get; }

    /** @var HeadersArray */
    public array $headers { get; }

    /** @var InputArray */
    public array $input { get; }

    /** @var HttpMethod */
    public string $method { get; }

    /** @var QueryArray */
    public array $query { get; }

    /** @var ServerArray */
    public array $server { get; }

    /** @var UploadsArray */
    public array $uploads { get; }

    public Url $url { get; }
}
