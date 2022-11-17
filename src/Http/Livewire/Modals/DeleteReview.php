<?php

namespace Shopfolio\Http\Livewire\Modals;

use Illuminate\Contracts\View\View;
use LivewireUI\Modal\ModalComponent;
use Shopfolio\Models\Shop\Review;

class DeleteReview extends ModalComponent
{
    public int $reviewID;

    public function mount(int $reviewID)
    {
        $this->reviewID = $reviewID;
    }

    public function delete()
    {
        Review::query()->find($this->reviewID)->delete();

        session()->flash('success', __('shopfolio::pages/products.reviews.modal.success_message'));

        $this->redirectRoute('shopfolio.reviews.index');
    }

    public static function modalMaxWidth(): string
    {
        return 'xl';
    }

    public function render(): View
    {
        return view('shopfolio::livewire.modals.delete-review');
    }
}
