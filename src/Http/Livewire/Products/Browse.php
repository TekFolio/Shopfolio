<?php

namespace Shopfolio\Http\Livewire\Products;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use Shopfolio\Repositories\Ecommerce\ProductRepository;

class Browse extends Component
{
    public function render(): View
    {
        return view('shopfolio::livewire.products.browse', [
            'total' => (new ProductRepository())->count(),
        ]);
    }
}
