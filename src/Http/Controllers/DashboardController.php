<?php

namespace Shopfolio\Http\Controllers;

class DashboardController extends ShopperBaseController
{
    /**
     * Display Shopfolio Dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('shopfolio::pages.dashboard.index');
    }
}
