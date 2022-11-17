<?php

namespace Shopfolio\Http\Livewire\Settings\Inventories;

use Livewire\Component;
use Shopfolio\Models\Shop\Inventory\Inventory;

class Browse extends Component
{
    public function render()
    {
        return view('shopfolio::livewire.settings.inventories.browse', [
            'inventories' => Inventory::query()->with('country')->get()->take(4),
        ]);
    }
}
