<?php

namespace LaraFlux\Facades;

use Illuminate\Support\Facades\Facade;

class LaraFlux extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'LaraFlux';
    }
}
