<?php

namespace Shopfolio\Http\Controllers;

use Shopfolio\Models\Shop\Inventory\Inventory;

class InventoryController extends ShopperBaseController
{
    /**
     * Display Inventory Index.
     *
     * @return \Illuminate\View\View
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('browse_inventories');

        return view('shopfolio::pages.settings.inventories.index');
    }

    /**
     * Display Inventory Create form view.
     *
     * @return \Illuminate\View\View
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('add_inventories');

        return view('shopfolio::pages.settings.inventories.create');
    }

    /**
     * Display Inventory update form.
     *
     * @return \Illuminate\View\View
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Inventory $inventory)
    {
        $this->authorize('edit_inventories');

        return view('shopfolio::pages.settings.inventories.edit', compact('inventory'));
    }
}
