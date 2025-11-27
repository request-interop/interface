<?php
declare(strict_types=1);

namespace RequestInterop\Interface;

use Throwable;

/**
 * The [_RequestThrowable_][] interface extends [_Throwable_][] to mark an
 * [_Exception_][] as request-related. It adds no class members.
 */
interface RequestThrowable extends Throwable
{
}
