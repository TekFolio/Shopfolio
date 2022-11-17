<?php

namespace Shopfolio\Http\Controllers\Ecommerce;

use Shopfolio\Http\Controllers\ShopperBaseController;
use Shopfolio\Repositories\Ecommerce\CollectionRepository;

class CollectionController extends ShopperBaseController
{
    /**
     * Return collections list view.
     *
     * @return \Illuminate\View\View
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('browse_collections');

        return view('shopfolio::pages.collections.index');
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
        $this->authorize('add_collections');

        return view('shopfolio::pages.collections.create');
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
        $this->authorize('edit_collections');

        return view('shopfolio::pages.collections.edit', [
            'collection' => (new CollectionRepository())->getById($id),
        ]);
    }
}
