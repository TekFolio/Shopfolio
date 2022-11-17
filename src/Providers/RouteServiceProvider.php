<?php

namespace Shopfolio\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Shopfolio;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Shopfolio\Http\Controllers';

    /**
     * Define the routes for the application.
     */
    public function map()
    {
        $this->configureRateLimiting();

        $this->mapApiRoutes();

        $this->mapAuthRoutes();

        $this->mapBackendRoutes();

        $this->mapCustomBackendRoute();
    }

    public function mapApiRoutes()
    {
        Route::namespace($this->namespace . '\Api')
            ->middleware('api')
            ->as('shopfolio.api.')
            ->prefix(Shopfolio::prefix() . '/api')
            ->group(realpath(SHOPFOLIO_PATH . '/routes/api.php'));
    }

    protected function mapAuthRoutes()
    {
        Route::namespace($this->namespace . '\Auth')
            ->middleware('web')
            ->as('shopfolio.')
            ->prefix(Shopfolio::prefix())
            ->group(realpath(SHOPFOLIO_PATH . '/routes/auth.php'));
    }

    protected function mapBackendRoutes()
    {
        Route::middleware(['shopfolio', 'dashboard'])
            ->prefix(Shopfolio::prefix())
            ->as('shopfolio.')
            ->namespace($this->namespace)
            ->group(realpath(SHOPFOLIO_PATH . '/routes/backend.php'));
    }

    public function mapCustomBackendRoute()
    {
        if (config('shopfolio.routes.custom_file')) {
            Route::middleware(['shopfolio', 'dashboard'])
                ->prefix(Shopfolio::prefix())
                ->namespace(config('shopfolio.system.controllers.namespace'))
                ->group(config('shopfolio.routes.custom_file'));
        }
    }

    protected function configureRateLimiting()
    {
        RateLimiter::for('shopfolio.api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
