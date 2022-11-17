<?php

namespace Shopfolio\Http\Livewire\Modals;

use Illuminate\Contracts\View\View;
use LivewireUI\Modal\ModalComponent;
use Shopfolio\Repositories\Ecommerce\ProductRepository;
use WireUi\Traits\Actions;

class RelatedList extends ModalComponent
{
    use Actions;

    public $product;

    public string $search = '';

    public array $exceptProductIds;

    public array $selectedProducts = [];

    public function mount(int $id, array $exceptProductIds = [])
    {
        $this->product = (new ProductRepository())->getById($id);
        $this->exceptProductIds = $exceptProductIds;
    }

    public static function modalMaxWidth(): string
    {
        return '2xl';
    }

    public function getProductsProperty()
    {
        return (new ProductRepository())
            ->where('name', '%' . $this->search . '%', 'like')
            ->whereNull('parent_id')
            ->get(['name', 'price_amount', 'id'])
            ->except($this->exceptProductIds);
    }

    public function addSelectedProducts()
    {
        $currentProducts = $this->product->relatedProducts->pluck('id')->toArray();
        $this->product->relatedProducts()->sync(array_merge($this->selectedProducts, $currentProducts));

        $this->emitUp('onProductsAddInRelated');

        $this->notification()->success(
            __('shopfolio::layout.status.added'),
            __('shopfolio::pages/products.notifications.related_added')
        );

        $this->closeModal();
    }

    public function render(): View
    {
        return view('shopfolio::livewire.modals.related-lists');
    }
}
