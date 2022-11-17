<?php

namespace Shopfolio\Http\Livewire\Modals;

use Illuminate\Contracts\View\View;
use LivewireUI\Modal\ModalComponent;
use Shopfolio\Models\Shop\Discount;

class DeleteDiscount extends ModalComponent
{
    public int $discountID;

    public function mount(int $discountID)
    {
        $this->discountID = $discountID;
    }

    public function delete()
    {
        Discount::query()->find($this->discountID)->delete();

        session()->flash('success', __('shopfolio::pages/discounts.modals.remove.success_message'));

        $this->redirectRoute('shopfolio.discounts.index');
    }

    public static function modalMaxWidth(): string
    {
        return 'xl';
    }

    public function render(): View
    {
        return view('shopfolio::livewire.modals.delete-discount');
    }
}
