<?php

namespace Shopfolio\Http\Controllers;

class InventoryHistoryController extends ShopperBaseController
{
    /**
     * Display Inventory History Index.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('shopfolio::pages.inventories.index');
    }
}
