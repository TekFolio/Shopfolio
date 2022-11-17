<?php

namespace Shopfolio\Http\Livewire\Products;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use Shopfolio\Repositories\Ecommerce\ProductRepository;
use Shopfolio\Repositories\InventoryRepository;

class Edit extends Component
{
    public Model $product;

    public Collection $inventories;

    public int $inventory;

    protected $listeners = ['productHasUpdated'];

    public function mount($product)
    {
        $this->product = $product;
        $this->inventories = $inventories = (new InventoryRepository())->get();
        $this->inventory = $inventories->where('is_default', true)->first()->id;
    }

    public function productHasUpdated(int $id)
    {
        $this->product = (new ProductRepository())->getById($id);
    }

    public function render(): View
    {
        return view('shopfolio::livewire.products.edit', [
            'currency' => shopfolio_currency(),
        ]);
    }
}
