<?php

namespace Shopfolio\Http\Controllers;

use Shopfolio\Models\Shop\Product\Attribute;

class AttributeController extends ShopperBaseController
{
    /**
     * Browse Attribute view page.
     *
     * @return \Illuminate\View\View
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('browse_attributes');

        return view('shopfolio::pages.settings.attributes.index');
    }

    /**
     * Create Attribute view page.
     *
     * @return \Illuminate\View\View
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('add_attributes');

        return view('shopfolio::pages.settings.attributes.create');
    }

    /**
     * Edit Attribute view page.
     *
     * @return \Illuminate\View\View
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Attribute $attribute)
    {
        $this->authorize('edit_attributes');

        return view('shopfolio::pages.settings.attributes.edit', compact('attribute'));
    }
}
