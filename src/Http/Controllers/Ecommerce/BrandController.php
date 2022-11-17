<?php

namespace Shopfolio\Http\Controllers\Ecommerce;

use Shopfolio\Http\Controllers\ShopperBaseController;
use Shopfolio\Repositories\Ecommerce\BrandRepository;

class BrandController extends ShopperBaseController
{
    /**
     * Return brands list view.
     *
     * @return \Illuminate\View\View
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('browse_brands');

        return view('shopfolio::pages.brands.index');
    }

    /**
     * Display Create view.
     *
     * @return \Illuminate\View\View
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('add_brands');

        return view('shopfolio::pages.brands.create');
    }

    /**
     * Display Edit form.
     *
     * @return \Illuminate\View\View
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(int $id)
    {
        $this->authorize('edit_brands');

        return view('shopfolio::pages.brands.edit', [
            'brand' => (new BrandRepository())->getById($id),
        ]);
    }
}
