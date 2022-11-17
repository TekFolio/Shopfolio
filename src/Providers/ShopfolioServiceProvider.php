<?php

namespace Shopfolio\Providers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\View\Compilers\BladeCompiler;
use Livewire\Component;
use Livewire\Livewire;
use Shopfolio\Console;
use Shopfolio\Models\Shop\Channel;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ShopfolioServiceProvider extends PackageServiceProvider
{
    /**
     * Shopfolio config files.
     *
     * @var array<string>
     */
    protected array $configFiles = [
        'auth',
        'components',
        'mails',
        'routes',
        'system',
        'settings',
    ];

    public function configurePackage(Package $package): void
    {
        $package
            ->name('shopfolio')
            ->hasCommands($this->getCommands())
            ->hasViewComponents(config('shopfolio.components.prefix', 'shopfolio'));
    }

    public function getCommands(): array
    {
        return [
            Console\InstallCommand::class,
            Console\PublishCommand::class,
            Console\SymlinkCommand::class,
            Console\UserCommand::class,
        ];
    }

    public function packageBooted(): void
    {
        $this->bootLivewireComponents();
        $this->bootBladeComponents();
        $this->bootModelRelationName();

        Builder::macro(
            'search',
            fn ($field, $string) => $string
                ? $this->where($field, 'like', '%' . $string . '%')
                : $this
        );
    }

    public function packageRegistered(): void
    {
        foreach ($this->provides() as $provide) {
            $this->app->register($provide);
        }

        $this->registerDatabase();
        $this->registerConfigFiles();
        $this->registerViews();
    }

    public function bootModelRelationName(): void
    {
        Relation::morphMap([
            'brand' => config('shopfolio.system.models.brand'),
            'category' => config('shopfolio.system.models.category'),
            'collection' => config('shopfolio.system.models.collection'),
            'product' => config('shopfolio.system.models.product'),
            'channel' => Channel::class,
        ]);
    }

    public function bootBladeComponents(): void
    {
        $prefix = config('shopfolio.components.prefix', 'shopfolio');

        $this->callAfterResolving(BladeCompiler::class, function (BladeCompiler $blade) use ($prefix) {
            foreach (config('shopfolio.components.blade', []) as $component) {
                $blade->component($component['class'], $component['alias'], $prefix);
            }
        });
    }

    public function bootLivewireComponents(): void
    {
        $prefix = config('shopfolio.components.prefix', 'shopfolio');

        Component::macro('notify', function ($params) {
            $this->dispatchBrowserEvent('notify', $params);
        });

        Livewire::listen('component.hydrate', function ($component) {
            $this->app->singleton(Component::class, fn () => $component);
        });

        foreach (config('shopfolio.components.livewire', []) as $alias => $component) {
            $alias = $prefix ? "$prefix-$alias" : $alias;

            Livewire::component($alias, $component);
        }
    }

    public function registerConfigFiles()
    {
        collect($this->configFiles)->each(function ($config) {
            $this->mergeConfigFrom(SHOPFOLIO_PATH . "/config/{$config}.php", "shopfolio.{$config}");
            $this->publishes([SHOPFOLIO_PATH . "/config/{$config}.php" => config_path("shopfolio/{$config}.php")], 'shopfolio-config');
        });
    }

    public function registerDatabase()
    {
        $this->loadMigrationsFrom(SHOPFOLIO_PATH . '/database/migrations');
        $this->publishes([SHOPFOLIO_PATH . '/database/seeders' => database_path('seeders')], 'shopfolio-seeders');
    }

    public function registeringPackage()
    {
        if (! defined('SHOPFOLIO_PATH')) {
            define('SHOPFOLIO_PATH', realpath(__DIR__ . '/..'));
        }
    }

    public function provides(): array
    {
        return [
            EventServiceProvider::class,
            RouteServiceProvider::class,
            SidebarServiceProvider::class,
            ShopfolioSidebarServiceProvider::class,
        ];
    }

    protected function registerViews()
    {
        $this->loadViewsFrom(SHOPFOLIO_PATH . '/resources/views', 'shopfolio');

        $langPath = 'vendor/shopfolio';

        $langPath = (function_exists('lang_path'))
            ? lang_path($langPath)
            : resource_path('lang/' . $langPath);

        $this->loadTranslationsFrom(SHOPFOLIO_PATH . '/resources/lang', 'shopfolio');
        $this->loadJsonTranslationsFrom($langPath);

        $this->publishes([SHOPFOLIO_PATH . '/resources/lang' => $langPath], 'shopfolio-lang');
    }
}
