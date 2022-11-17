<?php

namespace Shopfolio\Facades;

use Illuminate\Support\Facades\Facade;

class Shopfolio extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'shopfolio';
    }
}
