<?php

namespace Shopfolio\Providers;

use Illuminate\Support\ServiceProvider;
use Maatwebsite\Sidebar\SidebarManager;
use Shopfolio\Sidebar\AdminSidebar;

class SidebarServiceProvider extends ServiceProvider
{
    /**
     * Sidebar Manager.
     */
    public function boot(SidebarManager $manager)
    {
        $manager->register(AdminSidebar::class);
    }
}
