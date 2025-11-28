<?php
declare(strict_types=1);

namespace RequestInterop\Interface;

use StreamInterop\Interface\StringableStream;
use UploadInterop\Interface\UploadTypeAliases;
use UriInterop\Interface\UriStruct;

/**
 *
 * The [_RequestStruct_][] interface represents the current request values and
 * input stream.
 *
 * - Directives:
 *
 *     - Implementations MUST retain their properties in such way that they
 *       remain independent of the superglobal arrays.
 *
 * - Notes:
 *
 *     - **The interface defines readable properties, not getter methods.** PHP
 *       superglobals are presented as variables and not as functions; using
 *       properties instead of methods maintains symmetry with the language.
 *       In addition, using things like array access and null-coalesce against a
 *       property looks more idiomatic in PHP than with a getter method; it is
 *       the difference between `$request->query['foo'] ?? 'bar'` and
 *       `$request->getQuery()['foo'] ?? 'bar'` or
 *       `$request->query->get('foo', 'bar')`.
 *
 *     - **The interface defines property hooks for `get` but not `set`.** The
 *       interface only guarantees readability; writability is outside the scope
 *       of this package.
 *
 *     - **The properties and the superglobals should be decoupled from each
 *       other.** For example, this means that change to `$_GET` should not
 *       result in a corresponding change to `$query`. This is to keep the
 *       request object free from global mutable state.
 *
 * @phpstan-import-type request_cookies_array from RequestTypeAliases
 * @phpstan-import-type request_headers_array from RequestTypeAliases
 * @phpstan-import-type request_body_array from RequestTypeAliases
 * @phpstan-import-type request_method_string from RequestTypeAliases
 * @phpstan-import-type request_query_array from RequestTypeAliases
 * @phpstan-import-type request_server_array from RequestTypeAliases
 * @phpstan-import-type upload_structs_array from UploadTypeAliases
 */
interface RequestStruct
{
    /**
     * Corresponds to a parsed array of the request body content.
     *
     * - Directives:
     *
     *     - Implementations SHOULD populate the property value from a copy of
     *       the `$_POST` superglobal array but MAY use some other data source,
     *       such as a parsed or decoded representation of the request body.
     *
     * @var request_body_array
     */
    public array $body { get; }

    /**
     * Corresponds to a stream of the unparsed body content.
     *
     * - Directives:
     *
     *     - Implementations SHOULD use `php://input` as the encapsulated
     *       resource but MAY use some other data source.
     *
     * - Notes:
     *
     *     - **This property is a [Stream-Interop][] [_StringableStream_][].**
     *       Although most of the researched projects use a `string` proper for
     *       the raw body content, some use a resource. A [_StringableStream_][]
     *       allows for treating the content as a either a string or a resource
     *       stream.
     */
    public StringableStream $bodyStream { get; }

    /**
     * Corresponds to an array of the request cookie values.
     *
     * - Directives:
     *
     *     - Implementations SHOULD populate the property value from a copy of
     *       the `$_COOKIE` superglobal array but MAY use some other data source.
     *
     * @var request_cookies_array
     */
    public array $cookies { get; }

    /**
     * Corresponds to an array of the request headers.
     *
     * - Directives:
     *
     *     - Implementations SHOULD derive the property value from the
     *       `$server` array but MAY use some other data source.
     *
     *     - Implementations MUST normalize each header field array key to
     *       `lower-kebab-case`.
     *
     * @var request_headers_array
     */
    public array $headers { get; }

    /**
     * Corresponds to the request method.
     *
     * - Directives:
     *
     *     - Implementations SHOULD derive the property value from the
     *       `$server` array `'REQUEST_METHOD'` value but MAY use some
     *       other data source.
     *
     * @var request_method_string
     */
    public string $method { get; }

    /**
     * Corresponds to an array of the request query values.
     *
     * - Directives:
     *
     *     - Implementations SHOULD populate the property value from a copy of
     *       the `$_GET` superglobal array but MAY use some other data source.
     *
     * - Notes:
     *
     *     - **There is no requirement to keep `$query` and `$uri->queryParams`
     *       in sync.** Though they may originate from the same source, their
     *       values might diverge from each other.
     *
     * @var request_query_array
     */
    public array $query { get; }

    /**
     * Corresponds to an array of server and execution environment values.
     *
     * - Directives:
     *
     *     - Implementations SHOULD populate the property value from a copy of
     *       the `$_SERVER` superglobal array but MAY use some other data source.
     *
     * @var request_server_array
     */
    public array $server { get; }

    /**
     * An array of [_UploadStruct_][] instances corresponding to the uploaded
     * files in the request.
     *
     * - Directives:
     *
     *     - Implementations SHOULD derive the property value from the `$_FILES`
     *       superglobal array but MAY use some other data source.
     *
     * - Notes:
     *
     *     - **This property is an [Upload-Interop][] [`upload_structs_array`][].**
     *       Thus, `$uploads` takes the place of a `$_FILES` superglobal equivalent.
     *
     * @var upload_structs_array
     */
    public array $uploads { get; }

    /**
     * Corresponds to the requested URI.
     *
     * - Directives:
     *
     *     - Implementations SHOULD derive the property value from the
     *       `$server` array but MAY use some other data source.
     *
     * - Notes:
     *
     *     - **This property is a [Uri-Interop][] [_UriStruct_][].** Although
     *       most of the researched projects use a `string` for the request URI,
     *       some use an object. A [_UriStruct_][] allows for treating the URI
     *       as either an object or a string.
     */
    public UriStruct $uri { get; }
}
