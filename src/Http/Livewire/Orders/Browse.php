<?php

namespace Shopfolio\Http\Livewire\Orders;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use Shopfolio\Models\Shop\Order\Order;

class Browse extends Component
{
    public function render(): View
    {
        return view('shopfolio::livewire.orders.browse', [
            'total' => Order::query()->count(),
        ]);
    }
}
