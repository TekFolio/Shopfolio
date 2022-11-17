<?php

namespace Shopfolio\Http\Livewire\Products\Form;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;
use Milon\Barcode\Facades\DNS1DFacade;
use Shopfolio\Http\Livewire\Products\WithAttributes;
use Shopfolio\Repositories\Ecommerce\ProductRepository;
use Shopfolio\Repositories\InventoryHistoryRepository;
use Shopfolio\Traits\WithStock;
use WireUi\Traits\Actions;

class Inventory extends Component
{
    use Actions;
    use WithPagination;
    use WithAttributes;
    use WithStock;

    public Model $product;

    public Collection $inventories;

    public function mount($product, $inventories, $defaultInventory)
    {
        $this->inventories = $inventories;
        $this->inventory = $defaultInventory;
        $this->product = $product;
        $this->stock = $product->stock;
        $this->realStock = $product->stock;
        $this->sku = $product->sku;
        $this->barcode = $product->barcode;
        $this->securityStock = $product->security_stock;
    }

    public function paginationView(): string
    {
        return 'shopfolio::livewire.wire-pagination-links';
    }

    public function store()
    {
        $this->validate([
            'sku' => [
                'nullable',
                Rule::unique(shopfolio_table('products'), 'sku')->ignore($this->product->id),
            ],
            'barcode' => [
                'nullable',
                Rule::unique(shopfolio_table('products'), 'barcode')->ignore($this->product->id),
            ],
        ]);

        (new ProductRepository())->getById($this->product->id)->update([
            'sku' => $this->sku ?? null,
            'barcode' => $this->barcode ?? null,
            'security_stock' => $this->securityStock ?? null,
        ]);

        $this->notification()->success(
            __('shopfolio::layout.status.updated'),
            __('shopfolio::pages/products.notifications.stock_update')
        );
    }

    public function render(): View
    {
        return view('shopfolio::livewire.products.forms.form-inventory', [
            'currentStock' => (new InventoryHistoryRepository())
                ->where('inventory_id', $this->inventory)
                ->where('stockable_id', $this->product->id)
                ->get()
                ->sum('quantity'),
            'histories' => (new InventoryHistoryRepository())
                ->where('inventory_id', $this->inventory)
                ->where('stockable_id', $this->product->id)
                ->orderBy('created_at', 'desc')
                ->paginate(5),
            'barcodeImage' => $this->barcode
                ? DNS1DFacade::getBarcodeHTML($this->barcode, config('shopfolio.system.barcode_type'))
                : null,
        ]);
    }
}
