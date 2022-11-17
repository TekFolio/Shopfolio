<?php

namespace Shopfolio\Http\Livewire\Collections;

use Livewire\Component;
use Shopfolio\Repositories\Ecommerce\CollectionRepository;

class Browse extends Component
{
    public function render()
    {
        return view('shopfolio::livewire.collections.browse', [
            'total' => (new CollectionRepository())->count(),
        ]);
    }
}
