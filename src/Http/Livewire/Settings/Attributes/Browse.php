<?php

namespace Shopfolio\Http\Livewire\Settings\Attributes;

use Livewire\Component;
use Shopfolio\Models\Shop\Product\Attribute;

class Browse extends Component
{
    public function render()
    {
        return view('shopfolio::livewire.settings.attributes.browse', [
            'total' => Attribute::query()->count(),
        ]);
    }
}
