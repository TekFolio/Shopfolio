<?php

namespace Shopfolio\Http\Controllers\Ecommerce;

use Shopfolio\Http\Controllers\ShopperBaseController;
use Shopfolio\Repositories\Ecommerce\CategoryRepository;

class CategoryController extends ShopperBaseController
{
    /**
     * Display Categories resource view.
     *
     * @return \Illuminate\View\View
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('browse_categories');

        return view('shopfolio::pages.categories.index');
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
        $this->authorize('add_categories');

        return view('shopfolio::pages.categories.create');
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
        $this->authorize('edit_categories');

        return view('shopfolio::pages.categories.edit', [
            'category' => (new CategoryRepository())->getById($id),
        ]);
    }
}
