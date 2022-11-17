<?php

namespace Shopfolio\Http\Livewire\Products;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use Livewire\WithPagination;
use Shopfolio\Repositories\InventoryHistoryRepository;
use Shopfolio\Repositories\InventoryRepository;
use Shopfolio\Traits\WithStock;

class VariantStock extends Component
{
    use WithPagination;
    use WithStock;

    public Model $product;

    public function mount($variant)
    {
        $this->product = $variant;
        $this->stock = $variant->stock;
        $this->realStock = $variant->stock;
    }

    public function paginationView(): string
    {
        return 'shopfolio::livewire.wire-pagination-links';
    }

    public function render(): View
    {
        return view('shopfolio::livewire.products.variant-stock', [
            'currentStock' => (new InventoryHistoryRepository())
                ->where('inventory_id', $this->inventory)
                ->where('stockable_id', $this->product->id)
                ->get()
                ->sum('quantity'),
            'histories' => (new InventoryHistoryRepository())
                ->where('inventory_id', $this->inventory)
                ->where('stockable_id', $this->product->id)
                ->orderBy('created_at', 'desc')
                ->paginate(3),
            'inventories' => (new InventoryRepository())->all(),
        ]);
    }
}
