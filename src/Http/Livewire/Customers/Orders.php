<?php

namespace Shopfolio\Http\Livewire\Customers;

use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use Livewire\WithPagination;

class Orders extends Component
{
    use WithPagination;

    public Model $customer;

    public function mount($customer)
    {
        $this->customer = $customer;
    }

    public function paginationSimpleView(): string
    {
        return 'shopfolio::livewire.wire-mobile-pagination-links';
    }

    public function render()
    {
        return view('shopfolio::livewire.customers.orders', [
            'orders' => $this->customer->orders()
                ->with(['customer', 'items', 'shippingAddress', 'paymentMethod'])
                ->simplePaginate(3),
        ]);
    }
}
