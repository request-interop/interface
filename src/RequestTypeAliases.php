<?php
declare(strict_types=1);

namespace RequestInterop\Interface;

/**
 * @phpstan-type request_cookies_array array<string, string>
 *
 * @phpstan-type request_headers_array array<lowercase-string, string>
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
 * @phpstan-type request_method_string non-empty-string|uppercase-string
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
 * @phpstan-type request_server_array array<string, string>
 */
interface RequestTypeAliases
{
}
