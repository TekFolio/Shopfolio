<?php

namespace Shopfolio\Http\Controllers;

use Shopfolio\Models\Shop\Review;

class ReviewController extends ShopperBaseController
{
    /**
     * Display Reviews Index.
     *
     * @return \Illuminate\View\View
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('browse_products');

        return view('shopfolio::pages.reviews.index');
    }

    /**
     * Display review show page.
     *
     * @return \Illuminate\View\View
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Review $review)
    {
        $this->authorize('browse_products');

        return view('shopfolio::pages.reviews.show', compact('review'));
    }
}
