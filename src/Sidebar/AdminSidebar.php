<?php

namespace Shopfolio\Sidebar;

use Maatwebsite\Sidebar\Menu;
use Maatwebsite\Sidebar\ShouldCache;
use Maatwebsite\Sidebar\Sidebar;
use Maatwebsite\Sidebar\Traits\CacheableTrait;
use Shopfolio\Events\BuildingSidebar;

class AdminSidebar implements ShouldCache, Sidebar
{
    use CacheableTrait;

    protected Menu $menu;

    public function __construct(Menu $menu)
    {
        $this->menu = $menu;
    }

    /**
     * Build your sidebar implementation here.
     */
    public function build()
    {
        event($event = new BuildingSidebar($this->menu));
    }

    public function getMenu(): Menu
    {
        return $this->menu;
    }
}
