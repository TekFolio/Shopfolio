<?php

namespace Shopfolio;

use Illuminate\Support\Facades\Route;

class Shopfolio
{
    /**
     * Get the current Shopfolio version.
     */
    public static function version(): string
    {
        return '1.0.0';
    }

    /**
     * Get the URI path prefix utilized by Shopfolio.
     */
    public static function prefix(): string
    {
        return config('shopfolio.routes.prefix', 'shopfolio');
    }

    /**
     * Get the username used for authentication.
     */
    public static function username(): string
    {
        return config('shopfolio.auth.username', 'email');
    }

    /**
     * Register the Shop routes.
     *
     * @return Shopfolio
     */
    public function initializeRoute(): self
    {
        Route::namespace('Shopfolio\Http\Controllers')
            ->middleware(['shopfolio', 'shopfolio.setup'])
            ->as('shopfolio.')
            ->prefix(self::prefix())
            ->group(function () {
                Route::get('/configuration', 'SettingController@initialize')->name('initialize');
            });

        return $this;
    }
}
