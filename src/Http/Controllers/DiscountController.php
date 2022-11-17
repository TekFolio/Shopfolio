<?php

namespace Shopfolio\Http\Controllers;

use Shopfolio\Repositories\DiscountRepository;

class DiscountController extends ShopperBaseController
{
    /**
     * Display Discount Index.
     *
     * @return \Illuminate\View\View
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('browse_discounts');

        return view('shopfolio::pages.discounts.index');
    }

    /**
     * Display Create Discount View.
     *
     * @return \Illuminate\View\View
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('add_discounts');

        return view('shopfolio::pages.discounts.create');
    }

    /**
     * Display edit view.
     *
     * @return \Illuminate\View\View
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(int $id)
    {
        $this->authorize('edit_discounts');

        return view('shopfolio::pages.discounts.edit', [
            'discount' => (new DiscountRepository())->getById($id),
        ]);
    }
}
