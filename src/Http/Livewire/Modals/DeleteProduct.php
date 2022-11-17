<?php

namespace Shopfolio\Http\Livewire\Modals;

use Illuminate\Contracts\View\View;
use LivewireUI\Modal\ModalComponent;
use Shopfolio\Events\Products\ProductRemoved;
use Shopfolio\Repositories\Ecommerce\ProductRepository;

class DeleteProduct extends ModalComponent
{
    public int $productId;

    public string $type;

    public ?string $route = null;

    public function mount(int $id, string $type, string $route = null)
    {
        $this->productId = $id;
        $this->type = $type;
        $this->route = $route;
    }

    public function delete()
    {
        $product = (new ProductRepository())->getById($this->productId);

        event(new ProductRemoved($product));

        if ($this->type === 'product') {
            $product->delete();
        } else {
            $product->forceDelete();
        }

        session()->flash('success', __('The :item has been correctly removed.', ['item' => $this->type]));

        if ($this->type === 'product') {
            $this->redirectRoute('shopfolio.products.index');
        } else {
            $this->redirect($this->route);
        }
    }

    public static function modalMaxWidth(): string
    {
        return 'lg';
    }

    public function render(): View
    {
        return view('shopfolio::livewire.modals.delete-product');
    }
}
