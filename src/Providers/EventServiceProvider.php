<?php

namespace Shopfolio\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Shopfolio\Events\Products\ProductCreated;
use Shopfolio\Events\Products\ProductRemoved;
use Shopfolio\Events\Products\ProductUpdated;
use Shopfolio\Listeners\Products\CreateProductSubscriber;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        ProductCreated::class => [
            CreateProductSubscriber::class,
        ],

        ProductUpdated::class => [],

        ProductRemoved::class => [],
    ];
}
