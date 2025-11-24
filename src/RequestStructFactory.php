<?php
declare(strict_types=1);

namespace RequestInterop\Interface;

interface RequestStructFactory
{
    public function newRequest() : RequestStruct;
}
