# Request-Interop Standard Interface Package

This package provides a standard set of interoperable interfaces for encapsulating readable server-side request values in PHP 8.4 or later, in order to reduce the global mutable state problems that exist with PHP superglobals. It reflects, refines, and reconciles the common practices identified within [several pre-existing projects][README-RESEARCH.md].

The key words "MUST", "MUST NOT", "REQUIRED", "SHALL", "SHALL NOT", "SHOULD", "SHOULD NOT", "RECOMMENDED",  "MAY", and "OPTIONAL" in this document are to be interpreted as described in [BCP 14][] ([RFC 2119][], [RFC 8174][]).

## Interfaces

Request-Interop defines the following interfaces:

- [_RequestStruct_][] to represent the current request.
- [_RequestStructFactory_][] to create a new [_RequestStruct_][] instance
  representing the current request.

Request-Interop also defines a marker interface, [_RequestThrowable_][], for marking an [_Exception_][] as request-related.

Finally, Request-Interop defines a [_RequestTypeAliases_][] interface with PHPStan types to aid static analysis.

{{= docs }}

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
[BCP 14]: https://www.rfc-editor.org/info/bcp14
[README-PSR-7.md]: ./README-PSR-7.md
[README-RESEARCH.md]: ./README-RESEARCH.md
[RFC 2119]: https://www.rfc-editor.org/rfc/rfc2119.txt
[RFC 8174]: https://www.rfc-editor.org/rfc/rfc8174.txt
[Stream-Interop]: https://github.com/stream-interop/interface
[The Real Difference Between a URL and a URI]: https://danielmiessler.com/blog/difference-between-uri-url/
[Upload-Interop]: https://github.com/upload-interop/interface
[Uri-Interop]: https://github.com/uri-interop/interface
