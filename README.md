# Request-Interop Interface Package

This package provides a standard set of interoperable interfaces for encapsulating readable server-side request values in PHP 8.4 or later, in order to reduce the global mutable state problems that exist with PHP superglobals. It reflects and refines the common practices of over a dozen different userland projects.

The key words "MUST", "MUST NOT", "REQUIRED", "SHALL", "SHALL NOT", "SHOULD", "SHOULD NOT", "RECOMMENDED",  "MAY", and "OPTIONAL" in this document are to be interpreted as described in [BCP 14][] ([RFC 2119][], [RFC 8174][]).

## Interfaces

Request-Interop defines the following interfaces:

- _Request_ to represent the incoming request.
- _RequestUpload_ to represent an uploaded file.
- _RequestBody_ to represent the raw content of the request or an uploaded file.
- _RequestUrl_ to represent the requested URL.
- _RequestFactory_ to create instances of the above.

It also defines a _RequestTypeAliases_ interface with PHPStan types to aid static analysis.

Notes:

- **The interfaces define readable properties, not getter methods.** PHP superglobals are presented as variables and not as functions; using properties instead of methods maintains symmetry with the language. In addition, using things like array access and null-coalesce against a property looks more usually idiomatic in PHP than with a getter method; it is the difference between `$request->query['foo'] ?? 'bar'` and `$request->getQuery()['foo'] ?? 'bar'` or `$request->query->get('foo', 'bar')`.

- **The interfaces define property hooks for `get` but not `set`.** The interfaces only guarantee readability; writability is outside the scope of this package.

### _Request_

The _Request_ interface represents copies of the PHP superglobals (or their equivalents) and values derived from them. It defines these properties:

- `cookies_array $cookies { get; }`
    - Corresponds to a copy of the `$_COOKIES` superglobal array or its equivalent.

- `files_array $files { get; }`
    - Corresponds to a copy of the `$_FILES` superglobal array or its equivalent.

- `headers_array $headers { get; }`
    - Corresponds to an array of the request headers.
    - The values SHOULD be derived from `$_SERVER` or its equivalent.
    - Each array key MUST be the header field name in lower-kebab-case.

- `input_array $input { get; }`
    - Corresponds to an array of the request body values.
    - The values SHOULD be a copy `$_POST` superglobal array or its equivalent.
    - The values MAY be derived from a parsed or decoded representation of the request body.

- `method_string $method { get; }`
    - Corresponds to the request method.
    - The value SHOULD be derived from `$_SERVER` or its equivalent.

- `query_array $query { get; }`
    - Corresponds to an array of the request query values.
    - The values SHOULD be a copy of `$_GET` or its equivalent.

- `server_array $server { get; }`
    - Corresponds to a copy of the `$_SERVER` superglobal array or its equivalent.

- `uploads_array $uploads { get; }`
    - An array of _RequestUpload_ instances.
    - The values SHOULD be derived from `$_FILES` or its equivalent.
    - The index structure MUST correspond to the structure in which the uploaded files were indexed; cf. [README-UPLOADS.md][].

- `RequestUrl $url { get; }`
    - Corresponds to the requested URL.
    - The values SHOULD be derived from `$_SERVER` or its equivalent.

- `?RequestBody $body { get; }`
    - Corresponds to the raw request content.
    - The encapsulated resource SHOULD be `php://input` but MAY be some other resource.

Notes:

- **The `$body` property may be null.** Not all implementations require the presence of the raw request body.

- **There is no requirement to keep `$query` and `$url->queryParams` in sync.** Though they may originate from the same source, their values might diverge from each other.

### _RequestUpload_

The _RequestUpload_ interface represents a single uploaded file. It defines these properties and methods:

- `string $tmpName { get; }`
    - Corresponds to the `'tmp_name'` key in a `files_item_array`.

- `int $error { get; }`
    - Corresponds to the `'error'` key in a `files_item_array`.

- `?string $name { get; }`
    - Corresponds to the `'name'` key in a `files_item_array`.

- `?string $fullPath { get; }`
    - Corresponds to the `'full_path'` key in a `files_item_array`.

- `?string $type { get; }`
    - Corresponds to the `'type'` key in a `files_item_array`.

- `?int $size { get; }`
    - Corresponds to the `'size'` key in a `files_item_array`.

- `?RequestBody $body { get; }`
    - Corresponds to the raw upload content.
    - The encapsulated resource MUST be the `$tmpName` file.

- `move(string|Stringable $to) : bool`
    - Moves the uploaded file to another location, usually via `move_uploaded_file()`.

Notes:

- **The `$body` property may be null.** Not all implementations require the presence of the raw upload body.

### _RequestBody_

The _RequestBody_ interface extends [Stream-Interop _StringableStream_] to afford idempotent reading from the raw content of a _Request_ or a _RequestUpload_. It defines no additional properties or methods.

Implementations MAY be advertised as readonly only if they implement the [Stream-Interop _ReadonlyStream_] interface and adhere to its constraints.

Implementations MAY be advertised as immutable only if they implement the [Stream-Interop _ImmutableStream_] interface and adhere to its constraints.

### _RequestUrl_

The _RequestUrl_ interface extends [Uri-Interop _StringableComponents_] to afford reading the requested URL component values. It defines no additional properties or methods.

Implementations MUST validate that the scheme component and the host component are present and non-blank; when blank or not present, implementations MUST throw [_LogicException_][] (or an extension thereof).

Notes:

- **The interface is for a URL, not a URI.** This is because the scheme and host URI components must be present and non-blank (i.e. a non-empty string of something other than whitespace characters). Cf. [The Real Difference Between a URL and a URI][]: "A URL is a more specific version of a URI, so if the protocol is given or implied you should probably use URL."

### _RequestFactory_

The _RequestFactory_ interface defines the following methods.

- `newRequest()` returns a new _Request_ instance:

    ```php
    public function newRequest(
        ?cookies_array $cookies = null,
        ?files_array $files = null,
        ?headers_array $headers = null,
        ?input_array $input = null,
        ?method_string $method = null,
        ?query_array $query = null,
        ?server_array $server = null,
        ?uploads_array $uploads = null,
        ?RequestUrl $url = null,
        ?RequestBody $body = null,
    ) : Request;
    ```

- `newRequestUpload()` returns a new _RequestUpload_ instance:

    ```php
    public function newRequestUpload(
        string $tmpName,
        int $error,
        ?string $name = null,
        ?string $fullPath = null,
        ?string $type = null,
        ?int $size = null,
        ?RequestBody $body = null,
    ) : RequestUpload;
    ```

- `newRequestBody()` returns a new _RequestBody_ instance:

    ```php
    public function newRequestBody(string|resource $spec) : RequestBody;
    ```

- `newRequestUrl()` returns a new _RequestUrl_ instance:

    ```php
    public function newRequestUrl(server_array $server) : RequestUrl;
    ```

Notes:

- **All `newRequest()` arguments are optional.** The arguments are intended to override whatever defaults the implementation may provide; i.e., providing no arguments SHOULD return the default implementation object, such as one created from the superglobals.

- **The first two `newRequestUpload()` arguments are required.** A _RequestUpload_ MUST have at least a `$tmpName` and an `$error` code; all other values are optional, including the raw body content.

- **The `newRequestBody()` method `$spec` argument is either a string or a resource.** If the `$spec` is a string, implementations MUST treat it as a filename to be opened as a resource, as if by [`fopen()`][], in whatever mode the implementation finds appropriate.

### _RequestTypeAliases_

The _RequestTypeAliases_ interface provides these custom PHPStan types to aid static analysis:

- `cookies_array`: `array<string, string>`

- `files_array`: `array<array-key, files_group_array|files_item_array|files_array>` recursively up to 16 dimensions.

- `files_group_array`:
    ```
    array{
        tmp_name:string[],
        error:int[],
        name?:string[],
        full_path?:string[],
        type?:string[],
        size?:int[],
    }
    ```

- `files_item_array`:
    ```
    array{
        tmp_name:string,
        error:int,
        name?:string,
        full_path?:string,
        type?:string,
        size?:int,
    }
    ```

- `headers_array`: `array<lowercase-string, string>`

- `input_array`: `array<array-key, null|scalar|input_array>` recursively up to 16 dimensions.

- `method_string`: `uppercase-string`

- `query_array`: `array<array-key, string|query_array>` recursively up to 16 dimensions.

- `server_array`: `array<string, string>`

- `uploads_array`: `array<array-key, RequestUpload|uploads_array>` -- recursively up to 16 dimensions.

Notes:

- **The `files_*` types are defined from the `$_FILES` structure.** Cf. <https://www.php.net/manual/en/features.file-upload.post-method.php>.

- **The `method_string` is not a _Method_ interface.** Usually the reason for a _Method_ interface is to define `is(string $method) : bool` to make sure the comparison values use matching cases. However, the custom `method_string` type is `uppercase-string`, which means static analysis should catch mismatched casing.

- **The `query_array` type allows only  `string`, while `input_array` allows any `scalar`.** The `query_array` values correspond to `$_GET`, which is composed only of strings. However, `input_array` corresponds to any parsed or decoded form of the request content body; different parsing strategies, such as `json_decode()`, may return various scalar types.

- **The `server_array` type is `array<string, string>` and not `array<uppercase-string, string>`.** Some servers add `$_SERVER` keys in mixed case. For example, Microsoft IIS adds `IIS_WasUrlRewritten`.


## Implementations

Implementations advertised as readonly or immutable MUST be deeply readonly or immutable. With the exception of _RequestBody_ implementations meeting the specified readonly or immutable conditions, they MUST NOT encapsulate any references, resources, mutable objects, objects or arrays encapsulating references or resources or mutable objects, and so on.

Implementations MAY define additional elements not specified in these interfaces; implementations advertised as readonly or immutable MUST make those additional elements deeply readonly or immutable.

Notes:

- **Reflection does not invalidate advertisements of readonly or immutable implementations.** The ability of a consumer to use Reflection to mutate an implementation advertised as readonly or immutable does not constitute a failure to comply with Request-Interop.

- **Reference implementations** may be found at <https://github.com/request-interop/impl>.

## Q & A

### What userland projects were used as reference points for Request-Interop?

The pre-PSR-7 versions of Aura, Cake, Code Igniter, Horde, Joomla, Klein, Lithium, MediaWiki, Nette, Phalcon, Symfony, Yaf, Yii, and Zend. See this [project comparison][] for more information.

### How is Request-Interop different from PSR-7 _ServerRequestInterface_?

In short:

- _ServerRequestInterface_ attempts to model the incoming HTTP request message, plus application-specific context, with shallow and inconsistent immutability requirements.

- Request-Interop attempts to model the PHP superglobals, provides no space for application context, and requires that readonly or immutable implementations to be deeply so.

A longer answer is at [README-PSR-7.md][].

### How is Request-Interop different from the [Server-Side Request and Response Objects RFC](https://wiki.php.net/rfc/response)?

This package is an intellectual descendant of that RFC, similar in form but much reduced in scope: only the superglobal-equivalent arrays, the method string, the URL, and the uploads array properties remain. (Notably, the URL array is now a _RequestUrl_ interface.)

* * *

[Stream-Interop _ImmutableStream_]: https://github.com/stream-interop/interface#immutablestream
[_LogicException_]: https://php.net/LogicException
[Stream-Interop _ReadonlyStream_]: https://github.com/stream-interop/interface#readonlystream
[Stream-Interop _StringableStream_]: https://github.com/stream-interop/interface#stringablestream
[Uri-Interop _StringableComponents_]: https://github.com/uri-interop/interface#uri
[`fopen()`]: https://php.net/fopen
[BCP 14]: https://www.rfc-editor.org/info/bcp14
[project comparison]: https://docs.google.com/spreadsheets/d/e/2PACX-1vQzJP00bOAMYGSVQ8QIIJkXVdAg-OMEfkgna7-b2IsuoWN8x_TazxEYn-yVDF2XQIqnzmHqdDO3KEKx/pubhtml
[README-PSR-7.md]: ./README-PSR-7.md
[README-UPLOADS.md]: ./README-UPLOADS.md
[RFC 2119]: https://www.rfc-editor.org/rfc/rfc2119.txt
[RFC 8174]: https://www.rfc-editor.org/rfc/rfc8174.txt
[The Real Difference Between a URL and a URI]: https://danielmiessler.com/blog/difference-between-uri-url/
