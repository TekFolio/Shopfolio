<?php

namespace Shopfolio;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use const LC_TIME;
use Maatwebsite\Sidebar\Middleware\ResolveSidebars;
use Shopfolio\Contracts\FailedTwoFactorLoginResponse as FailedTwoFactorLoginResponseContract;
use Shopfolio\Contracts\TwoFactorAuthenticationProvider as TwoFactorAuthenticationProviderContract;
use Shopfolio\Events\BuildingSidebar;
use Shopfolio\Events\Handlers;
use Shopfolio\Http\Composers\GlobalComposer;
use Shopfolio\Http\Composers\SidebarCreator;
use Shopfolio\Http\Middleware;
use Shopfolio\Http\Responses\FailedTwoFactorLoginResponse;
use Shopfolio\Providers\ShopfolioServiceProvider;
use Shopfolio\Services\TwoFactor\TwoFactorAuthenticationProvider;
use Spatie\Permission\Middlewares\PermissionMiddleware;
use Spatie\Permission\Middlewares\RoleMiddleware;

class FrameworkServiceProvider extends ServiceProvider
{
    protected array $middlewares = [
        'dashboard' => Middleware\Dashboard::class,
        'shopfolio.guest' => Middleware\RedirectIfAuthenticated::class,
        'shopfolio.setup' => Middleware\HasConfiguration::class,
        'role' => RoleMiddleware::class,
        'permission' => PermissionMiddleware::class,
    ];

    public function boot()
    {
        $this->bootDateFormatted();
        $this->registerMiddleware($this->app['router']);
        $this->registerShopSettingRoute();
        $this->registerViewsComposer();

        $this->app->register(ShopfolioServiceProvider::class);
    }

    public function register()
    {
        $this->app['events']->listen(BuildingSidebar::class, Handlers\RegisterDashboardSidebar::class);
        $this->app['events']->listen(BuildingSidebar::class, Handlers\RegisterShopSidebar::class);
        $this->app['events']->listen(BuildingSidebar::class, Handlers\RegisterOrderSidebar::class);

        $this->app->singleton('shopfolio', fn () => new Shopfolio());
        $this->app->singleton(TwoFactorAuthenticationProviderContract::class, TwoFactorAuthenticationProvider::class);
        $this->app->singleton(FailedTwoFactorLoginResponseContract::class, FailedTwoFactorLoginResponse::class);

        $this->app->bind(StatefulGuard::class, fn () => Auth::guard(config('shopfolio.auth.guard', null)));
    }

    public function bootDateFormatted()
    {
        // setLocale for php. Enables ->formatLocalized() with localized values for dates.
        setlocale(LC_TIME, config('shopfolio.system.locale'));

        // setLocale to use Carbon source locales. Enables diffForHumans() localized.
        Carbon::setLocale(config('app.locale'));
    }

    public function registerViewsComposer()
    {
        view()->composer('*', GlobalComposer::class);
        view()->creator('shopfolio::components.layouts.app.sidebar.secondary', SidebarCreator::class);
    }

    public function registerShopSettingRoute()
    {
        (new Shopfolio())->initializeRoute();
    }

    public function registerMiddleware(Router $router)
    {
        $router->middlewareGroup('shopfolio', array_merge([
            'web',
            Middleware\Authenticate::class,
            ResolveSidebars::class,
        ], config('shopfolio.routes.middleware', [])));

        foreach ($this->middlewares as $name => $middleware) {
            $router->aliasMiddleware($name, $middleware);
        }
    }

    public function provides(): array
    {
        return ['shopfolio'];
    }
}
