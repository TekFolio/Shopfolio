<?php

namespace Shopfolio\Http\Controllers\Ecommerce;

use Shopfolio\Http\Controllers\ShopperBaseController;
use Shopfolio\Repositories\Ecommerce\ProductRepository;

class ProductController extends ShopperBaseController
{
    public function index()
    {
        $this->authorize('browse_products');

        return view('shopfolio::pages.products.index');
    }

    public function create()
    {
        $this->authorize('add_products');

        return view('shopfolio::pages.products.create');
    }

    public function edit(int $id)
    {
        $this->authorize('edit_products');

        return view('shopfolio::pages.products.edit', [
            'product' => (new ProductRepository())
                ->with(['inventoryHistories', 'variations', 'categories', 'collections', 'channels', 'relatedProducts', 'attributes'])
                ->getById($id),
        ]);
    }

    public function variant(int $product, int $id)
    {
        $this->authorize('edit_products');

        return view('shopfolio::pages.products.variant', [
            'product' => (new ProductRepository())->getById($product),
            'variant' => (new ProductRepository())
                ->with('inventoryHistories')
                ->getById($id),
        ]);
    }
}
