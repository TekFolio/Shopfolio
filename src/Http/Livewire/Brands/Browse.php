<?php

namespace Shopfolio\Http\Livewire\Brands;

use Livewire\Component;
use Shopfolio\Repositories\Ecommerce\BrandRepository;

class Browse extends Component
{
    public function render()
    {
        return view('shopfolio::livewire.brands.browse', [
            'total' => (new BrandRepository())->count(),
        ]);
    }
}
