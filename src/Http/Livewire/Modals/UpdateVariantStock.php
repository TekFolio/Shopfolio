<?php

namespace Shopfolio\Http\Livewire\Modals;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Livewire\WithPagination;
use LivewireUI\Modal\ModalComponent;
use Shopfolio\Repositories\Ecommerce\ProductRepository;
use Shopfolio\Repositories\InventoryHistoryRepository;
use Shopfolio\Repositories\InventoryRepository;
use Shopfolio\Traits\WithStock;

class UpdateVariantStock extends ModalComponent
{
    use WithPagination;
    use WithStock;

    public Model $product;

    public function mount(int $id)
    {
        $this->product = $variant = (new ProductRepository())->getById($id);
        $this->stock = $variant->stock;
        $this->realStock = $variant->stock;
    }

    public static function modalMaxWidth(): string
    {
        return '3xl';
    }

    public function paginationView(): string
    {
        return 'shopfolio::livewire.wire-pagination-links';
    }

    public function render(): View
    {
        return view('shopfolio::livewire.modals.update-variant-stock', [
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
