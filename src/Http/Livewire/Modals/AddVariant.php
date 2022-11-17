<?php

namespace Shopfolio\Http\Livewire\Modals;

use Illuminate\Contracts\View\View;
use LivewireUI\Modal\ModalComponent;
use Shopfolio\Http\Livewire\Products\WithAttributes;
use Shopfolio\Repositories\Ecommerce\ProductRepository;
use Shopfolio\Repositories\InventoryRepository;
use WireUi\Traits\Actions;

class AddVariant extends ModalComponent
{
    use Actions;
    use WithAttributes;

    public int $productId;

    public string $currency;

    public $quantity;

    public $files = [];

    protected $listeners = [
        'shopfolio:filesUpdated' => 'onFilesUpdated',
    ];

    public function mount(int $productId, string $currency)
    {
        $this->productId = $productId;
        $this->currency = $currency;
    }

    public function onFilesUpdated($files)
    {
        $this->files = $files;
    }

    public function save()
    {
        $this->validate($this->rules());

        $product = (new ProductRepository())->create([
            'name' => $this->name,
            'slug' => $this->name,
            'sku' => $this->sku,
            'type' => $this->type,
            'barcode' => $this->barcode,
            'is_visible' => true,
            'security_stock' => $this->securityStock,
            'old_price_amount' => $this->old_price_amount,
            'price_amount' => $this->price_amount,
            'cost_amount' => $this->cost_amount,
            'parent_id' => $this->productId,
        ]);

        if (collect($this->files)->isNotEmpty()) {
            collect($this->files)->each(
                fn ($file) => $product->addMedia($file)->toMediaCollection(config('shopfolio.system.storage.disks.uploads'))
            );
        }

        if ($this->quantity && count($this->quantity) > 0) {
            foreach ($this->quantity as $inventory => $value) {
                $product->mutateStock(
                    $inventory,
                    $value,
                    [
                        'event' => __('shopfolio::pages/products.inventory.initial'),
                        'old_quantity' => $value,
                    ]
                );
            }
        }

        $this->notification()->success(
            __('shopfolio::layout.status.added'),
            __('shopfolio::pages/products.notifications.variation_create')
        );

        $this->emit('onVariantAdded');

        $this->closeModal();
    }

    public function rules(): array
    {
        return [
            'name' => 'required|unique:' . shopfolio_table('products'),
            'sku' => 'nullable|unique:' . shopfolio_table('products'),
            'barcode' => 'nullable|unique:' . shopfolio_table('products'),
        ];
    }

    public static function modalMaxWidth(): string
    {
        return '3xl';
    }

    public function render(): View
    {
        return view('shopfolio::livewire.modals.add-variant', [
            'inventories' => (new InventoryRepository())->get(),
        ]);
    }
}
