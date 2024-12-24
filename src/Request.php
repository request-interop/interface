<?php
declare(strict_types=1);

namespace RequestInterop\Interface;

/**
 * @phpstan-type CookiesArray array<string, string>
 *
 * @phpstan-type FilesArray mixed[]
 *
 * @phpstan-type FilesArrayItem array{
 *     tmp_name:string,
 *     error:int,
 *     name?:string,
 *     full_path?:string,
 *     type?:string,
 *     size?:int,
 * }
 *
 * @phpstan-type FilesArrayGroup array{
 *     tmp_name:string[],
 *     error:int[],
 *     name?:string[],
 *     full_path?:string[],
 *     type?:string[],
 *     size?:int[],
 * }
 *
 * @phpstan-type HeadersArray array<lowercase-string, string>
 *
 * @phpstan-type InputArray mixed[]
 *
 * @phpstan-type ScalarArray mixed[]
 *
 * @phpstan-type MethodString uppercase-string
 *
 * @phpstan-type QueryArray mixed[]
 *
 * @phpstan-type ServerArray array<string, string>
 *
 * @phpstan-type UploadsArray mixed[]
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

    /** @var MethodString */
    public string $method { get; }

    /** @var QueryArray */
    public array $query { get; }

    /** @var ServerArray */
    public array $server { get; }

    /** @var UploadsArray */
    public array $uploads { get; }

    public Url $url { get; }
}
