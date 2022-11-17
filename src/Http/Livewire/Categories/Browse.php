<?php

namespace Shopfolio\Http\Livewire\Categories;

use Livewire\Component;
use Shopfolio\Repositories\Ecommerce\CategoryRepository;

class Browse extends Component
{
    public function render()
    {
        return view('shopfolio::livewire.categories.browse', [
            'total' => (new CategoryRepository())->count(),
        ]);
    }
}
