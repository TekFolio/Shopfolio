<?php

namespace Shopfolio\Http\Livewire\Products\Form;

use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use Shopfolio\Models\Shop\Product\ProductAttribute;
use Shopfolio\Models\Shop\Product\ProductAttributeValue;
use Shopfolio\Traits\WithAttributes;
use WireUi\Traits\Actions;

class Attributes extends Component
{
    use Actions;
    use WithAttributes;

    public Model $product;

    public int $productId;

    public Collection $attributes;

    public Collection $productAttributes;

    protected $listeners = ['onProductAttributeAdded'];

    public function mount($product)
    {
        $this->product = $product;
        $this->productId = $product->id;

        $this->onProductAttributeAdded();
    }

    public function onProductAttributeAdded()
    {
        $this->productAttributes = $this->getProductAttributes();
        $this->attributes = $this->getAttributes();
    }

    public function removeProductAttributeValue(int $id): void
    {
        ProductAttributeValue::find($id)->delete();

        $this->notification()->success(
            __('shopfolio::pages/products.attributes.session.delete_value'),
            __('shopfolio::pages/products.attributes.session.delete_value_message')
        );

        $this->emitSelf('onProductAttributeAdded');
    }

    /**
     * Remove Attribute to product.
     *
     * @throws Exception
     */
    public function removeProductAttribute(int $id)
    {
        ProductAttribute::query()->find($id)->delete();

        $this->productAttributes = $this->getProductAttributes();
        $this->attributes = $this->getAttributes();

        $this->notification()->success(
            __('shopfolio::pages/products.attributes.session.delete'),
            __('shopfolio::pages/products.attributes.session.delete_message')
        );
    }

    public function render(): View
    {
        return view('shopfolio::livewire.products.forms.form-attributes');
    }
}
