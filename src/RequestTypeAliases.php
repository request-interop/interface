<?php
declare(strict_types=1);

namespace RequestInterop\Interface;

/**
 * @phpstan-type cookies_array array<string, string>
 *
 * @phpstan-type files_array    array<array-key, files_group_array|files_item_array|files_array_00>
 * @phpstan-type files_array_00 array<array-key, files_group_array|files_item_array|files_array_01>
 * @phpstan-type files_array_01 array<array-key, files_group_array|files_item_array|files_array_02>
 * @phpstan-type files_array_02 array<array-key, files_group_array|files_item_array|files_array_03>
 * @phpstan-type files_array_03 array<array-key, files_group_array|files_item_array|files_array_04>
 * @phpstan-type files_array_04 array<array-key, files_group_array|files_item_array|files_array_05>
 * @phpstan-type files_array_05 array<array-key, files_group_array|files_item_array|files_array_06>
 * @phpstan-type files_array_06 array<array-key, files_group_array|files_item_array|files_array_07>
 * @phpstan-type files_array_07 array<array-key, files_group_array|files_item_array|files_array_08>
 * @phpstan-type files_array_08 array<array-key, files_group_array|files_item_array|files_array_09>
 * @phpstan-type files_array_09 array<array-key, files_group_array|files_item_array|files_array_0A>
 * @phpstan-type files_array_0A array<array-key, files_group_array|files_item_array|files_array_0B>
 * @phpstan-type files_array_0B array<array-key, files_group_array|files_item_array|files_array_0C>
 * @phpstan-type files_array_0C array<array-key, files_group_array|files_item_array|files_array_0D>
 * @phpstan-type files_array_0D array<array-key, files_group_array|files_item_array|files_array_0E>
 * @phpstan-type files_array_0E array<array-key, files_group_array|files_item_array|files_array_0F>
 * @phpstan-type files_array_0F array<array-key, files_group_array|files_item_array>
 *
 * @phpstan-type files_group_array array{
 *     tmp_name:string[],
 *     error:int[],
 *     name?:string[],
 *     full_path?:string[],
 *     type?:string[],
 *     size?:int[],
 * }
 *
 * @phpstan-type files_item_array array{
 *     tmp_name:string,
 *     error:int,
 *     name?:string,
 *     full_path?:string,
 *     type?:string,
 *     size?:int,
 * }
 *
 * @phpstan-type headers_array array<lowercase-string, string>
 *
 * @phpstan-type input_array    array<array-key, null|scalar|input_array_00>
 * @phpstan-type input_array_00 array<array-key, null|scalar|input_array_01>
 * @phpstan-type input_array_01 array<array-key, null|scalar|input_array_02>
 * @phpstan-type input_array_02 array<array-key, null|scalar|input_array_03>
 * @phpstan-type input_array_03 array<array-key, null|scalar|input_array_04>
 * @phpstan-type input_array_04 array<array-key, null|scalar|input_array_05>
 * @phpstan-type input_array_05 array<array-key, null|scalar|input_array_06>
 * @phpstan-type input_array_06 array<array-key, null|scalar|input_array_07>
 * @phpstan-type input_array_07 array<array-key, null|scalar|input_array_08>
 * @phpstan-type input_array_08 array<array-key, null|scalar|input_array_09>
 * @phpstan-type input_array_09 array<array-key, null|scalar|input_array_0A>
 * @phpstan-type input_array_0A array<array-key, null|scalar|input_array_0B>
 * @phpstan-type input_array_0B array<array-key, null|scalar|input_array_0C>
 * @phpstan-type input_array_0C array<array-key, null|scalar|input_array_0D>
 * @phpstan-type input_array_0D array<array-key, null|scalar|input_array_0E>
 * @phpstan-type input_array_0E array<array-key, null|scalar|input_array_0F>
 * @phpstan-type input_array_0F array<array-key, null|scalar>
 *
 * @phpstan-type method_string uppercase-string
 *
 * @phpstan-type query_array    array<array-key, string|query_array_00>
 * @phpstan-type query_array_00 array<array-key, string|query_array_01>
 * @phpstan-type query_array_01 array<array-key, string|query_array_02>
 * @phpstan-type query_array_02 array<array-key, string|query_array_03>
 * @phpstan-type query_array_03 array<array-key, string|query_array_04>
 * @phpstan-type query_array_04 array<array-key, string|query_array_05>
 * @phpstan-type query_array_05 array<array-key, string|query_array_06>
 * @phpstan-type query_array_06 array<array-key, string|query_array_07>
 * @phpstan-type query_array_07 array<array-key, string|query_array_08>
 * @phpstan-type query_array_08 array<array-key, string|query_array_09>
 * @phpstan-type query_array_09 array<array-key, string|query_array_0A>
 * @phpstan-type query_array_0A array<array-key, string|query_array_0B>
 * @phpstan-type query_array_0B array<array-key, string|query_array_0C>
 * @phpstan-type query_array_0C array<array-key, string|query_array_0D>
 * @phpstan-type query_array_0D array<array-key, string|query_array_0E>
 * @phpstan-type query_array_0E array<array-key, string|query_array_0F>
 * @phpstan-type query_array_0F array<array-key, string>
 *
 * @phpstan-type server_array array<string, string>
 *
 * @phpstan-type uploads_array    array<array-key, RequestUpload|uploads_array_00>
 * @phpstan-type uploads_array_00 array<array-key, RequestUpload|uploads_array_01>
 * @phpstan-type uploads_array_01 array<array-key, RequestUpload|uploads_array_02>
 * @phpstan-type uploads_array_02 array<array-key, RequestUpload|uploads_array_03>
 * @phpstan-type uploads_array_03 array<array-key, RequestUpload|uploads_array_04>
 * @phpstan-type uploads_array_04 array<array-key, RequestUpload|uploads_array_05>
 * @phpstan-type uploads_array_05 array<array-key, RequestUpload|uploads_array_06>
 * @phpstan-type uploads_array_06 array<array-key, RequestUpload|uploads_array_07>
 * @phpstan-type uploads_array_07 array<array-key, RequestUpload|uploads_array_08>
 * @phpstan-type uploads_array_08 array<array-key, RequestUpload|uploads_array_09>
 * @phpstan-type uploads_array_09 array<array-key, RequestUpload|uploads_array_0A>
 * @phpstan-type uploads_array_0A array<array-key, RequestUpload|uploads_array_0B>
 * @phpstan-type uploads_array_0B array<array-key, RequestUpload|uploads_array_0C>
 * @phpstan-type uploads_array_0C array<array-key, RequestUpload|uploads_array_0D>
 * @phpstan-type uploads_array_0D array<array-key, RequestUpload|uploads_array_0E>
 * @phpstan-type uploads_array_0E array<array-key, RequestUpload|uploads_array_0F>
 * @phpstan-type uploads_array_0F array<array-key, string>
 */
interface RequestTypeAliases
{
}
