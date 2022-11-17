<?php

namespace Shopfolio\Http\Livewire\Reviews;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use Shopfolio\Models\Shop\Review;

class Browse extends Component
{
    public function render(): View
    {
        return view('shopfolio::livewire.reviews.browse', [
            'total' => Review::query()->count(),
        ]);
    }
}
