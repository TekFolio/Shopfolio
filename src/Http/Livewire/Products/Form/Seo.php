<?php

namespace Shopfolio\Http\Livewire\Products\Form;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Shopfolio\Repositories\Ecommerce\ProductRepository;
use Shopfolio\Traits\WithSeoAttributes;
use WireUi\Traits\Actions;

class Seo extends Component
{
    use Actions;
    use WithSeoAttributes;

    public Model $product;

    public int $productId;

    public string $slug;

    public $seoAttributes = [
        'name' => 'name',
        'description' => 'description',
    ];

    public function mount($product)
    {
        $this->product = $product;
        $this->productId = $product->id;
        $this->slug = $product->slug;
        $this->seoTitle = $product->seo_title;
        $this->seoDescription = $product->seo_description;
    }

    public function store()
    {
        $this->validate([
            'slug' => [
                'required',
                Rule::unique(shopfolio_table('products'), 'sku')->ignore($this->productId),
            ],
        ]);

        (new ProductRepository())->getById($this->productId)->update([
            'slug' => str_slug($this->slug),
            'seo_title' => $this->seoTitle,
            'seo_description' => str_limit($this->seoDescription, 157),
        ]);

        $this->emit('productHasUpdated', $this->productId);

        $this->notification()->success(
            __('shopfolio::layout.status.updated'),
            __('shopfolio::pages/products.notifications.seo_update')
        );
    }

    public function render(): View
    {
        return view('shopfolio::livewire.products.forms.form-seo');
    }
}
