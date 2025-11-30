<?php
declare(strict_types=1);

namespace RequestInterop\Interface;

/**
 * The [_RequestStructFactory_][] interface affords creating a new
 * [_RequestStruct_][] instance for the current request.
 */
interface RequestStructFactory
{
    /**
     * Creates a new [_RequestStruct_][] instance representing the current
     * request.
     *
     * - Directives:
     *
     *     - Implementations SHOULD create the new [_RequestStruct_][] from the
     *       superglobals and `php://input` of the current request, but MAY use
     *       some other data source.
     *
     *     - Implementations SHOULD catch all [_Throwable_][]s encountered during
     *       new [_RequestStruct_][] creation.
     *
     *     - Implementations SHOULD provide defaults for missing or invalid
     *       values discovered during [_RequestStruct_][] creation.
     *
     *     - Inplementations MAY throw a [_RequestThrowable_][] on failure to
     *       create a new [_RequestStruct_][].
     *
     * - Notes:
     *
     *     - **This method should always succeed.** All of the researched
     *       implementations always return a new instance, even if they have to
     *       provide default values for missing or invalid request elements.
     *
     *       However, Response-Interop recognizes that there may be times where
     *       catastrophic failure is appropriate, thus the allowance for
     *       throwing a [_RequestThrowable_][].
     *
     *       Consumers should consider failure to create a request object as
     *       deserving a 4xx ("Client Error") or 5xx ("Server Error") HTTP
     *       response code.
     */
    public function newRequest() : RequestStruct;
}
