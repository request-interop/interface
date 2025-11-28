# Request-Interop Standard Interface Package

This package provides a standard set of interoperable interfaces for encapsulating readable server-side request values in PHP 8.4 or later, in order to reduce the global mutable state problems that exist with PHP superglobals. It reflects, refines, and reconciles the common practices identified within [several pre-existing projects][README-RESEARCH.md].

The key words "MUST", "MUST NOT", "REQUIRED", "SHALL", "SHALL NOT", "SHOULD", "SHOULD NOT", "RECOMMENDED",  "MAY", and "OPTIONAL" in this document are to be interpreted as described in [BCP 14][] ([RFC 2119][], [RFC 8174][]).

## Interfaces

Request-Interop defines the following interfaces:

- [_RequestStruct_][] represents the current request values and input stream.
- [_RequestStructFactory_][] affords creating a new [_RequestStruct_][] instance for the current request.
- [_RequestThrowable_][] extends [_Throwable_][] to mark an [_Exception_][] as request-related.
- [_RequestTypeAliases_][] provides custom PHPStan types to aid static analysis.

### _RequestStruct_

The [_RequestStruct_][] interface represents the current request values and
input stream.

- Directives:

    - Implementations MUST retain their properties in such way that they
      remain independent of the superglobal arrays.

- Notes:

    - **The interface defines readable properties, not getter methods.** PHP
      superglobals are presented as variables and not as functions; using
      properties instead of methods maintains symmetry with the language.
      In addition, using things like array access and null-coalesce against a
      property looks more idiomatic in PHP than with a getter method; it is
      the difference between `$request->query['foo'] ?? 'bar'` and
      `$request->getQuery()['foo'] ?? 'bar'` or
      `$request->query->get('foo', 'bar')`.

    - **The interface defines property hooks for `get` but not `set`.** The
      interface only guarantees readability; writability is outside the scope
      of this package.

    - **The properties and the superglobals should be decoupled from each
      other.** For example, this means that change to `$_GET` should not
      result in a corresponding change to `$query`. This is to keep the
      request object free from global mutable state.

#### _RequestStruct_ Properties

- ```php
  public request_body_array $body { get; }
  ```
    - Corresponds to an array of the request body values.

    - Directives:

        - Implementations SHOULD populate the property value from a copy of
          the `$_POST` superglobal array but MAY use some other data source,
          such as a parsed or decoded representation of the request body.

- ```php
  public request_cookies_array $cookies { get; }
  ```
    - Corresponds to an array of the request cookie values.

    - Directives:

        - Implementations SHOULD populate the property value from a copy of
          the `$_COOKIE` superglobal array but MAY use some other data source.

- ```php
  public request_headers_array $headers { get; }
  ```
    - Corresponds to an array of the request headers.

    - Directives:

        - Implementations SHOULD derive the property value from the
          `$server` array but MAY use some other data source.

        - Implementations MUST normalize each header field array key to
          `lower-kebab-case`.

- ```php
  public StreamInterop\Interface\StringableStream $input { get; }
  ```
    - Corresponds to the raw body content.

    - Directives:

        - Implementations SHOULD use `php://input` as the encapsulated
          resource but MAY use some other data source.

    - Notes:

        - **This property is a [Stream-Interop][] [_StringableStream_][].**
          Although most of the researched projects use a `string` proper for
          the raw body content, some use a resource. A [_StringableStream_][]
          allows for treating the content as a either a string or a resource
          stream.

- ```php
  public request_method_string $method { get; }
  ```
    - Corresponds to the request method.

    - Directives:

        - Implementations SHOULD derive the property value from the
          `$server` array `'REQUEST_METHOD'` value but MAY use some
          other data source.

- ```php
  public request_query_array $query { get; }
  ```
    - Corresponds to an array of the request query values.

    - Directives:

        - Implementations SHOULD populate the property value from a copy of
          the `$_GET` superglobal array but MAY use some other data source.

    - Notes:

        - **There is no requirement to keep `$query` and `$uri->queryParams`
          in sync.** Though they may originate from the same source, their
          values might diverge from each other.

- ```php
  public request_server_array $server { get; }
  ```
    - Corresponds to an array of server and execution environment values.

    - Directives:

        - Implementations SHOULD populate the property value from a copy of
          the `$_SERVER` superglobal array but MAY use some other data source.

- ```php
  public upload_structs_array $uploads { get; }
  ```
    - An array of [_UploadStruct_][] instances corresponding to the uploaded
    files in the request.

    - Directives:

        - Implementations SHOULD derive the property value from the `$_FILES`
          superglobal array but MAY use some other data source.

    - Notes:

        - **This property is an [Upload-Interop][] [`upload_structs_array`][].**
          Thus, `$uploads` takes the place of a `$_FILES` superglobal equivalent.

- ```php
  public UriInterop\Interface\UriStruct $uri { get; }
  ```
    - Corresponds to the requested URI.

    - Directives:

        - Implementations SHOULD derive the property value from the
          `$server` array but MAY use some other data source.

    - Notes:

        - **This property is a [Uri-Interop][] [_UriStruct_][].** Although
          most of the researched projects use a `string` for the request URI,
          some use an object. A [_UriStruct_][] allows for treating the URI
          as either an object or a string.

### _RequestStructFactory_

The [_RequestStructFactory_][] interface affords creating a new
[_RequestStruct_][] instance for the current request.

#### _RequestStructFactory_ Methods

- ```php
  public function newRequest() : RequestStruct;
  ```
    - Creates a new [_RequestStruct_][] instance representing the current
    request.

    - Directives:

        - Implementations SHOULD create the new [_RequestStruct_][] from the
          superglobals and `php://input` of the current request, but MAY use
          some other data source.

### _RequestThrowable_

The [_RequestThrowable_][] interface extends [_Throwable_][] to mark an
[_Exception_][] as request-related. It adds no class members.

### _RequestTypeAliases_

The [_RequestTypeAliases_][] interface provides custom PHPStan types to aid static analysis.

- ```
  request_cookies_array: array<string, string>
  ```
   - An `array` representing `$_COOKIE` data.

- ```
  request_headers_array: array<lowercase-string, string>
  ```
   - An `array` consisting of a header field name string in `lower-kebab-case`
     and the corresponding header field value string.

- ```
  request_body_array: array<array-key, null|scalar|request_body_array>
  ```
    - An `array` representing `$_POST` data (or other data parsed or decoded
      from the request body) up to 16 dimensions.

- ```
  request_method_string: uppercase-string
  ```
    - A `string` representing the HTTP request method.

- ```
  request_query_array: array<array-key, string|request_query_array>
  ```
    - An `array` representing `$_GET` data up to 16 dimensions.

- ```
  request_server_array: array<string, string>
  ```
    - **The `request_server_array` type is `array<string, string>` and not
      `array<uppercase-string, string>`.** Some servers add `$_SERVER` keys
      in mixed case; for example, Microsoft IIS adds `IIS_WasUrlRewritten`.

- Notes:

    - **The `request_query_array` type allows only `string`, while
      `request_body_array` allows any `scalar`.** The `request_query_array`
      values correspond to `$_GET`, which is composed only of strings.
      However, `request_body_array` corresponds to any parsed or decoded
      form of the request content body; different parsing strategies, such
      as `json_decode()`, may return various scalar types.

    - **The `*_[00-0F]` types are to enable limited recursion.** PHPStan does
      not handle recursive type aliases, so `request_body_array` and
      `request_query_array` cannot ever refer back to themselves. As a
      result, those type aliases refer to the `*_[00-0F]` types to enable
      recursion to 16 dimensions. Consumers need not use these recursion-enabling
      type aliases.

## Implementations

Implementations advertised as readonly or immutable MUST be deeply readonly or immutable. With the exception of [_StringableStream_][] implementations meeting the specified readonly or immutable conditions, they MUST NOT encapsulate any references, resources, mutable objects, objects or arrays encapsulating references or resources or mutable objects, and so on.

Implementations MAY define additional class members not specified in these interfaces; implementations advertised as readonly or immutable MUST make those additional class members deeply readonly or immutable.

Notes:

- **Reflection does not invalidate advertisements of readonly or immutable implementations.** The ability of a consumer to use Reflection to mutate an implementation advertised as readonly or immutable does not constitute a failure to comply with Request-Interop.

- **Reference implementations** may be found at <https://github.com/request-interop/impl>.

## Q & A

### Why is _RequestStruct_ not identical to a client-side request interface?

None of the researched projects model their request objects that way.

A more general answer is from Fowler in _Patterns of Enterprise Application Architecture_
(2003, p 21):

> ... I think there is a good distinction to be made between an interface that
> you provide as a service to others and your use of someone else's service.
> ... I find it beneficial to think about these differently because the
> difference in clients alters the way you think about the service.

Request-Interop attempts to model an interface that *uses* a request received
from an external source, not one that *provides* a request for sending.

### How is Request-Interop different from PSR-7 _ServerRequestInterface_?

In short:

- _ServerRequestInterface_ attempts to model the incoming HTTP request message, plus application-specific context, with shallow and inconsistent immutability requirements.

- Request-Interop attempts to model the PHP superglobals, provides no space for application context, and requires readonly or immutable implementations to be deeply so.

A longer answer is at [README-PSR-7.md][].

### How is Request-Interop different from the [Server-Side Request and Response Objects RFC](https://wiki.php.net/rfc/response)?

This package is an intellectual descendant of that RFC, similar in form but much reduced in scope: only the superglobal-equivalent arrays, the method string, the URI, and the uploads properties remain.

### Why is there a separate _RequestStructFactory_ ?

Of the 16 researched projects, only 3 provide a separate factory class. The
remainder provide either a static factory method on the request object itself,
or use only `new` for creating a request object.

However, the Response-Interop request interface is modeled as a struct, meaning
it can have no methods, only properties.

As such, even though the use of a factory class is decidedly the minority
position, Response-Interop asserts that it is the more suitable choice here.

Further, Response-Interop opines that a separate factory interface better
separates the concern of creating or building the _RequestStruct_ using the
superglobals and related environment elements.

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
[`upload_structs_array`]: https://github.com/upload-interop/interface#uploadtypealiases
[`files_array`]: https://github.com/upload-interop/interface#uploadtypealiases
[BCP 14]: https://datatracker.ietf.org/doc/bcp14/
[README-PSR-7.md]: ./README-PSR-7.md
[README-RESEARCH.md]: ./README-RESEARCH.md
[RFC 2119]: https://datatracker.ietf.org/doc/html/rfc2119
[RFC 8174]: https://datatracker.ietf.org/doc/html/rfc8174
[Stream-Interop]: https://github.com/stream-interop/interface
[The Real Difference Between a URL and a URI]: https://danielmiessler.com/blog/difference-between-uri-url/
[Upload-Interop]: https://github.com/upload-interop/interface
[Uri-Interop]: https://github.com/uri-interop/interface
