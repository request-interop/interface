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
     */
    public function newRequest() : RequestStruct;
}
