<?php

namespace Shopfolio\Http\Controllers\Ecommerce;

use Shopfolio\Http\Controllers\ShopperBaseController;
use Shopfolio\Models\Shop\Order\Order;

class OrderController extends ShopperBaseController
{
    /**
     * Return orders list view.
     *
     * @return \Illuminate\View\View
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('browse_orders');

        return view('shopfolio::pages.orders.index');
    }

    /**
     * Display order detail view.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Order $order)
    {
        $this->authorize('read_orders');

        return view('shopfolio::pages.orders.show', [
            'order' => $order->load(['customer', 'items', 'shippingAddress', 'paymentMethod']),
        ]);
    }
}
