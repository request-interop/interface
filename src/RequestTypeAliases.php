<?php
declare(strict_types=1);

namespace RequestInterop\Interface;

/**
 * [_RequestTypeAliases_][] provides custom PHPStan types to aid static analysis.
 *
 * - ```
 *   request_cookies_array: array<array-key, string|request_cookies_array>
 *   ```
 *    - An `array` representing `$_COOKIE` data up to 16 dimensions.
 *
 * - ```
 *   request_headers_array: array<int|lowercase-string, string>
 *   ```
 *    - An `array` consisting of a header field name string in `lower-kebab-case`
 *      and the corresponding header field value string.
 *
 * - ```
 *   request_body_array: array<array-key, null|scalar|request_body_array>
 *   ```
 *     - An `array` representing `$_POST` data (or other data parsed or decoded
 *       from the request body) up to 16 dimensions.
 *
 * - ```
 *   request_method_string: non-empty-string&uppercase-string
 *   ```
 *     - A `string` representing the HTTP request method.
 *
 * - ```
 *   request_query_array: array<array-key, string|request_query_array>
 *   ```
 *     - An `array` representing `$_GET` data up to 16 dimensions.
 *
 * - ```
 *   request_server_array: array<array-key, string>
 *   ```
 *     - **The `request_server_array` type is `array<string, string>` and not
 *       `array<uppercase-string, string>`.** Some servers add `$_SERVER` keys
 *       in mixed case; for example, Microsoft IIS adds `IIS_WasUrlRewritten`.
 *
 * - Notes:
 *
 *     - **The `request_query_array` type allows only `string`, while
 *       `request_body_array` allows any `scalar`.** The `request_query_array`
 *       values correspond to `$_GET`, which is composed only of strings.
 *       However, `request_body_array` corresponds to any parsed or decoded
 *       form of the request content body; different parsing strategies, such
 *       as `json_decode()`, may return various scalar types.
 *
 *     - **The `*_[00-0F]` types are to enable limited recursion.** PHPStan does
 *       not handle recursive type aliases, so `request_body_array` and
 *       `request_query_array` cannot ever refer back to themselves. As a
 *       result, those type aliases refer to the `*_[00-0F]` types to enable
 *       recursion to 16 dimensions. Consumers need not use these recursion-enabling
 *       type aliases.
 *
 * @phpstan-type request_cookies_array    array<array-key, string|request_cookies_array_00>
 * @phpstan-type request_cookies_array_00 array<array-key, string|request_cookies_array_01>
 * @phpstan-type request_cookies_array_01 array<array-key, string|request_cookies_array_02>
 * @phpstan-type request_cookies_array_02 array<array-key, string|request_cookies_array_03>
 * @phpstan-type request_cookies_array_03 array<array-key, string|request_cookies_array_04>
 * @phpstan-type request_cookies_array_04 array<array-key, string|request_cookies_array_05>
 * @phpstan-type request_cookies_array_05 array<array-key, string|request_cookies_array_06>
 * @phpstan-type request_cookies_array_06 array<array-key, string|request_cookies_array_07>
 * @phpstan-type request_cookies_array_07 array<array-key, string|request_cookies_array_08>
 * @phpstan-type request_cookies_array_08 array<array-key, string|request_cookies_array_09>
 * @phpstan-type request_cookies_array_09 array<array-key, string|request_cookies_array_0A>
 * @phpstan-type request_cookies_array_0A array<array-key, string|request_cookies_array_0B>
 * @phpstan-type request_cookies_array_0B array<array-key, string|request_cookies_array_0C>
 * @phpstan-type request_cookies_array_0C array<array-key, string|request_cookies_array_0D>
 * @phpstan-type request_cookies_array_0D array<array-key, string|request_cookies_array_0E>
 * @phpstan-type request_cookies_array_0E array<array-key, string|request_cookies_array_0F>
 * @phpstan-type request_cookies_array_0F array<array-key, string>
 *
 * @phpstan-type request_headers_array array<int|lowercase-string, string>
 *
 * @phpstan-type request_body_array    array<array-key, null|scalar|request_body_array_00>
 * @phpstan-type request_body_array_00 array<array-key, null|scalar|request_body_array_01>
 * @phpstan-type request_body_array_01 array<array-key, null|scalar|request_body_array_02>
 * @phpstan-type request_body_array_02 array<array-key, null|scalar|request_body_array_03>
 * @phpstan-type request_body_array_03 array<array-key, null|scalar|request_body_array_04>
 * @phpstan-type request_body_array_04 array<array-key, null|scalar|request_body_array_05>
 * @phpstan-type request_body_array_05 array<array-key, null|scalar|request_body_array_06>
 * @phpstan-type request_body_array_06 array<array-key, null|scalar|request_body_array_07>
 * @phpstan-type request_body_array_07 array<array-key, null|scalar|request_body_array_08>
 * @phpstan-type request_body_array_08 array<array-key, null|scalar|request_body_array_09>
 * @phpstan-type request_body_array_09 array<array-key, null|scalar|request_body_array_0A>
 * @phpstan-type request_body_array_0A array<array-key, null|scalar|request_body_array_0B>
 * @phpstan-type request_body_array_0B array<array-key, null|scalar|request_body_array_0C>
 * @phpstan-type request_body_array_0C array<array-key, null|scalar|request_body_array_0D>
 * @phpstan-type request_body_array_0D array<array-key, null|scalar|request_body_array_0E>
 * @phpstan-type request_body_array_0E array<array-key, null|scalar|request_body_array_0F>
 * @phpstan-type request_body_array_0F array<array-key, null|scalar>
 *
 * @phpstan-type request_method_string non-empty-string&uppercase-string
 *
 * @phpstan-type request_query_array    array<array-key, string|request_query_array_00>
 * @phpstan-type request_query_array_00 array<array-key, string|request_query_array_01>
 * @phpstan-type request_query_array_01 array<array-key, string|request_query_array_02>
 * @phpstan-type request_query_array_02 array<array-key, string|request_query_array_03>
 * @phpstan-type request_query_array_03 array<array-key, string|request_query_array_04>
 * @phpstan-type request_query_array_04 array<array-key, string|request_query_array_05>
 * @phpstan-type request_query_array_05 array<array-key, string|request_query_array_06>
 * @phpstan-type request_query_array_06 array<array-key, string|request_query_array_07>
 * @phpstan-type request_query_array_07 array<array-key, string|request_query_array_08>
 * @phpstan-type request_query_array_08 array<array-key, string|request_query_array_09>
 * @phpstan-type request_query_array_09 array<array-key, string|request_query_array_0A>
 * @phpstan-type request_query_array_0A array<array-key, string|request_query_array_0B>
 * @phpstan-type request_query_array_0B array<array-key, string|request_query_array_0C>
 * @phpstan-type request_query_array_0C array<array-key, string|request_query_array_0D>
 * @phpstan-type request_query_array_0D array<array-key, string|request_query_array_0E>
 * @phpstan-type request_query_array_0E array<array-key, string|request_query_array_0F>
 * @phpstan-type request_query_array_0F array<array-key, string>
 *
 * @phpstan-type request_server_array array<array-key, string>
 */
interface RequestTypeAliases
{
}
