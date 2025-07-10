# Request-Interop Standard Interface Package

This package provides a standard set of interoperable interfaces for encapsulating readable server-side request values in PHP 8.4 or later, in order to reduce the global mutable state problems that exist with PHP superglobals. It reflects, refines, and reconciles the common practices identified within [several pre-existing projects][README-RESEARCH.md].

The key words "MUST", "MUST NOT", "REQUIRED", "SHALL", "SHALL NOT", "SHOULD", "SHOULD NOT", "RECOMMENDED",  "MAY", and "OPTIONAL" in this document are to be interpreted as described in [BCP 14][] ([RFC 2119][], [RFC 8174][]).

## Interfaces

Request-Interop defines the following interfaces:

- [_RequestStruct_][] to represent the incoming request.
- [_RequestStructFactory_][] to create [_RequestStruct_][] instances.

Request-Interop also defines a marker interface, [_RequestThrowable_][], for marking an [_Exception_][] as request-related.

Finally, Request-Interop defines a [_RequestTypeAliases_][] interface with PHPStan types to aid static analysis.

### _RequestStruct_

The [_RequestStruct_][] interface represents copies of the PHP superglobals (or their equivalents) and values derived from them. It defines these properties:

- `body_array $body { get; }`
    - Corresponds to an array of the request body values.
    - The values SHOULD be a copy of the `$_POST` superglobal array or its equivalent.
    - The values MAY be derived from a parsed or decoded representation of the request body.

- `cookies_array $cookies { get; }`
    - Corresponds to a copy of the `$_COOKIES` superglobal array or its equivalent.

- `headers_array $headers { get; }`
    - Corresponds to an array of the request headers.
    - The values SHOULD be derived from the `$_SERVER` superglobal array or its equivalent.
    - Each array key MUST be the header field name in lower-kebab-case.

- `StringableStream $input { get; }`
    - Corresponds to the raw request content.
    - The encapsulated resource SHOULD be `php://input`.

- `method_string $method { get; }`
    - Corresponds to the request method.
    - The value SHOULD be derived from the `$_SERVER` superglobal array or its equivalent.

- `query_array $query { get; }`
    - Corresponds to an array of the request query values.
    - The values SHOULD be a copy of the `$_GET` superglobal array or its equivalent.

- `server_array $server { get; }`
    - Corresponds to a copy of the `$_SERVER` superglobal array or its equivalent.

- `uploads_array $uploads { get; }`
    - An array of [_UploadStruct_][] instances.
    - The values SHOULD be derived from the `$_FILES` superglobal array or its equivalent.

- `UriStruct $uri { get; }`
    - Corresponds to the requested URI.
    - The values SHOULD be derived from the `$_SERVER` superglobal array or its equivalent.

Notes:

- **The interface defines readable properties, not getter methods.** PHP superglobals are presented as variables and not as functions; using properties instead of methods maintains symmetry with the language. In addition, using things like array access and null-coalesce against a property looks more idiomatic in PHP than with a getter method; it is the difference between `$request->query['foo'] ?? 'bar'` and `$request->getQuery()['foo'] ?? 'bar'` or `$request->query->get('foo', 'bar')`.

- **The interfaces defines property hooks for `get` but not `set`.** The interface only guarantees readability; writability is outside the scope of this package.

- **There is no requirement to keep `$query` and `$uri->queryParams` in sync.** Though they may originate from the same source, their values might diverge from each other.

- **The `$input` property is a [Stream-Interop][] [_StringableStream_][].** Although most of the researched projects use a `string` proper for the raw body content, some use a resource. A [_StringableString_][] allows for treating the content as a either a string or a resource stream.

- **The `$uploads` property is an [Upload-Interop][] [`uploads_array`][].** This takes the place of a `$_FILES` superglobal equivalent.

- **The `$uri` property is a [Uri-Interop][] [_UriStruct_][].** Although most of the researched projects use a `string` proper for the request URI, some use an object. A [_UriStruct_][] allows for treating the URI as either an object or a string.

### _RequestStructFactory_

The [_RequestStructFactory_][] interface affords creating a [_RequestStruct_][] instance:

-
    ```php
    public function newRequest(
        ?body_array $body = null,
        ?cookies_array $cookies = null,
        ?headers_array $headers = null,
        ?StringableStream $input = null,
        ?method_string $method = null,
        ?query_array $query = null,
        ?server_array $server = null,
        ?uploads_array $uploads = null,
        ?UriStruct $uri = null,
    ) : RequestStruct;
    ```

Notes:

- **All `newRequest()` arguments are optional.** The arguments are intended to override whatever defaults the implementation may provide; i.e., providing no arguments SHOULD return the implementation's default [_RequestStruct_][], such as one created from the superglobals.

### _RequestThrowable_

The [_RequestThrowable_][] interface extends [_Throwable_][] to mark an [_Exception_][] as request-related. It adds no class members.

### _RequestTypeAliases_

The _RequestTypeAliases_ interface provides these custom PHPStan types to aid static analysis:

- `cookies_array`: `array<string, string>`

- `headers_array`: `array<lowercase-string, string>`

- `body_array`: `array<array-key, null|scalar|body_array>` recursively up to 16 dimensions.

- `method_string`: `uppercase-string`

- `query_array`: `array<array-key, string|query_array>` recursively up to 16 dimensions.

- `server_array`: `array<string, string>`

Notes:

- **The `query_array` type allows only `string`, while `body_array` allows any `scalar`.** The `query_array` values correspond to `$_GET`, which is composed only of strings. However, `body_array` corresponds to any parsed or decoded form of the request content body; different parsing strategies, such as `json_decode()`, may return various scalar types.

- **The `server_array` type is `array<string, string>` and not `array<uppercase-string, string>`.** Some servers add `$_SERVER` keys in mixed case; for example, Microsoft IIS adds `IIS_WasUrlRewritten`.

- **The `*_[00-0F]` types are to enable limited recursion.** PHPStan does not handle recursive type aliases, so `body_array` and `query_array` cannot ever refer back to themselves. As a result, those type aliases refer to the `*_[00-0F]` types to enable recursion to 16 dimensions. Consumers need not use these recursion-enabling type aliases.


## Implementations

Implementations advertised as readonly or immutable MUST be deeply readonly or immutable. With the exception of [_StringableStream_][] implementations meeting the specified readonly or immutable conditions, they MUST NOT encapsulate any references, resources, mutable objects, objects or arrays encapsulating references or resources or mutable objects, and so on.

Implementations MAY define additional class members not specified in these interfaces; implementations advertised as readonly or immutable MUST make those additional class members deeply readonly or immutable.

Notes:

- **Reflection does not invalidate advertisements of readonly or immutable implementations.** The ability of a consumer to use Reflection to mutate an implementation advertised as readonly or immutable does not constitute a failure to comply with Request-Interop.

- **Reference implementations** may be found at <https://github.com/request-interop/impl>.

## Q & A

### How is Request-Interop different from PSR-7 _ServerRequestInterface_?

In short:

- _ServerRequestInterface_ attempts to model the incoming HTTP request message, plus application-specific context, with shallow and inconsistent immutability requirements.

- Request-Interop attempts to model the PHP superglobals, provides no space for application context, and requires readonly or immutable implementations to be deeply so.

A longer answer is at [README-PSR-7.md][].

### How is Request-Interop different from the [Server-Side Request and Response Objects RFC](https://wiki.php.net/rfc/response)?

This package is an intellectual descendant of that RFC, similar in form but much reduced in scope: only the superglobal-equivalent arrays, the method string, the URI, and the uploads properties remain.

* * *

[_Exception_]: https://php.net/Exception
[_RequestStruct_]: #requeststruct
[_RequestStructFactory_]: #requeststructfactory
[_RequestThrowable_]: #requestthrowable
[_RequestTypeAliases_]: #requesttypealiases
[_StringableStream_]: https://github.com/stream-interop/interface#stringablestream
[_Throwable_]: https://php.net/Throwable
[_UploadStruct_]: https://github.com/uri-interop/interface#uristruct
[_UriStruct_]: https://github.com/uri-interop/interface#uristruct
[`uploads_array`]: https://github.com/upload-interop/interface#uploadtypealiases
[`files_array`]: https://github.com/upload-interop/interface#uploadtypealiases
[BCP 14]: https://www.rfc-editor.org/info/bcp14
[README-PSR-7.md]: ./README-PSR-7.md
[README-RESEARCH.md]: ./README-RESEARCH.md
[RFC 2119]: https://www.rfc-editor.org/rfc/rfc2119.txt
[RFC 8174]: https://www.rfc-editor.org/rfc/rfc8174.txt
[Stream-Interop]: https://github.com/stream-interop/interface
[The Real Difference Between a URL and a URI]: https://danielmiessler.com/blog/difference-between-uri-url/
[Upload-Interop]: https://github.com/upload-interop/interface
[Uri-Interop]: https://github.com/uri-interop/interface
