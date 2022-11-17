<?php

namespace Shopfolio\Http\Livewire\Products;

use Illuminate\Contracts\View\View;
use Milon\Barcode\Facades\DNS1DFacade;
use Shopfolio\Http\Livewire\AbstractBaseComponent;
use Shopfolio\Models\Shop\Channel;
use Shopfolio\Models\Shop\Inventory\Inventory;
use Shopfolio\Repositories\Ecommerce\BrandRepository;
use Shopfolio\Repositories\Ecommerce\CategoryRepository;
use Shopfolio\Repositories\Ecommerce\CollectionRepository;
use Shopfolio\Repositories\Ecommerce\ProductRepository;
use Shopfolio\Traits\WithChoicesBrands;
use Shopfolio\Traits\WithSeoAttributes;

class Create extends AbstractBaseComponent
{
    use WithAttributes;
    use WithSeoAttributes;
    use WithChoicesBrands;

    public ?Channel $defaultChannel = null;

    public array $category_ids = [];

    public array $collection_ids = [];

    public $quantity;

    public $files = [];

    public array $seoAttributes = [
        'name' => 'name',
        'description' => 'description',
    ];

    protected $listeners = [
        'productAdded',
        'trix:valueUpdated' => 'onTrixValueUpdate',
        'shopfolio:filesUpdated' => 'onFilesUpdated',
    ];

    public function mount()
    {
        $this->defaultChannel = Channel::query()->where('slug', 'web-store')->first();
    }

    public function onTrixValueUpdate($value)
    {
        $this->description = $value;
    }

    public function onFilesUpdated($files)
    {
        $this->files = $files;
    }

    public function rules(): array
    {
        return [
            'name' => 'bail|required',
            'sku' => 'nullable|unique:' . shopfolio_table('products'),
            'barcode' => 'nullable|unique:' . shopfolio_table('products'),
            'brand_id' => 'nullable|integer|exists:' . shopfolio_table('brands') . ',id',
        ];
    }

    public function store()
    {
        $this->validate($this->rules());

        $product = (new ProductRepository())->create([
            'name' => $this->name,
            'slug' => $this->name,
            'sku' => $this->sku,
            'barcode' => $this->barcode,
            'description' => $this->description,
            'security_stock' => $this->securityStock,
            'is_visible' => $this->isVisible,
            'old_price_amount' => $this->old_price_amount,
            'price_amount' => $this->price_amount,
            'cost_amount' => $this->cost_amount,
            'type' => $this->type,
            'requires_shipping' => $this->requiresShipping,
            'backorder' => $this->backorder,
            'published_at' => $this->publishedAt ?? now(),
            'seo_title' => $this->seoTitle,
            'seo_description' => str_limit($this->seoDescription, 157),
            'weight_value' => $this->weightValue ?? null,
            'weight_unit' => $this->weightUnit,
            'height_value' => $this->heightValue ?? null,
            'height_unit' => $this->heightUnit,
            'width_value' => $this->widthValue ?? null,
            'width_unit' => $this->widthUnit,
            'volume_value' => $this->volumeValue ?? null,
            'volume_unit' => $this->volumeUnit,
            'brand_id' => $this->brand_id ?? null,
        ]);

        if (collect($this->files)->isNotEmpty()) {
            collect($this->files)->each(
                fn ($file) => $product->addMedia($file)->toMediaCollection(config('shopfolio.system.storage.disks.uploads'))
            );
        }

        if (collect($this->category_ids)->isNotEmpty()) {
            $product->categories()->attach($this->category_ids);
        }

        if (collect($this->collection_ids)->isNotEmpty()) {
            $product->collections()->attach($this->collection_ids);
        }

        $product->channels()->attach($this->defaultChannel->id);

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

        session()->flash('success', __('shopfolio::pages/products.notifications.create'));

        $this->redirectRoute('shopfolio.products.index');
    }

    public function render(): View
    {
        return view('shopfolio::livewire.products.create', [
            'brands' => (new BrandRepository())
                ->makeModel()
                ->scopes('enabled')
                ->select('name', 'id')
                ->get(),
            'categories' => (new CategoryRepository())
                ->makeModel()
                ->scopes('enabled')
                ->tree()
                ->orderBy('name')
                ->get()
                ->toTree(),
            'collections' => (new CollectionRepository())->with('media')->get(['name', 'id']),
            'inventories' => Inventory::query()->get(['name', 'id']),
            'currency' => shopfolio_currency(),
            'barcodeImage' => $this->barcode
                ? DNS1DFacade::getBarcodeHTML($this->barcode, config('shopfolio.system.barcode_type'))
                : null,
        ]);
    }
}
