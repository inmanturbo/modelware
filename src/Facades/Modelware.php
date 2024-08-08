<?php

namespace Inmanturbo\Modelware\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Inmanturbo\Modelware\Modelware
 */
class Modelware extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Inmanturbo\Modelware\Modelware::class;
    }
}
