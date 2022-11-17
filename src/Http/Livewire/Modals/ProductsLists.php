<?php

namespace Shopfolio\Http\Livewire\Modals;

use Illuminate\Contracts\View\View;
use LivewireUI\Modal\ModalComponent;
use Shopfolio\Repositories\Ecommerce\CollectionRepository;
use Shopfolio\Repositories\Ecommerce\ProductRepository;
use WireUi\Traits\Actions;

class ProductsLists extends ModalComponent
{
    use Actions;

    public $collection;

    public string $search = '';

    public array $exceptProductIds;

    public array $selectedProducts = [];

    public function mount(int $id, array $exceptProductIds = [])
    {
        $this->collection = (new CollectionRepository())->getById($id);
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
            ->get(['name', 'price_amount', 'id'])
            ->except($this->exceptProductIds);
    }

    public function addSelectedProducts()
    {
        $currentProducts = $this->collection->products->pluck('id')->toArray();
        $this->collection->products()->sync(array_merge($this->selectedProducts, $currentProducts));

        $this->emitUp('onProductsAddInCollection');

        $this->notification()->success(
            __('shopfolio::layout.status.added'),
            __('shopfolio::pages/collections.modal.success_message')
        );

        $this->closeModal();
    }

    public function render(): View
    {
        return view('shopfolio::livewire.modals.products-lists');
    }
}
