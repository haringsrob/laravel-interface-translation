<?php

namespace Haringsrob\LaravelInterfaceTranslation\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelInterfaceTranslation extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Haringsrob\LaravelInterfaceTranslation\LaravelInterfaceTranslation::class;
    }
}
