<?php

namespace Shopfolio\Http\Livewire\Reviews;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use Shopfolio\Models\Shop\Review;
use WireUi\Traits\Actions;

class Show extends Component
{
    use Actions;

    public Review $review;

    public bool $approved;

    public function mount(Review $review)
    {
        $this->review = $review->load(['reviewrateable', 'author']);
        $this->approved = $review->approved;
    }

    public function updatedApproved()
    {
        $this->approved = ! $this->review->approved;
        $this->review->update(['approved' => ! $this->review->approved]);

        $this->notification()->success(
            __('shopfolio::layout.status.updated'),
            __('shopfolio::pages/products.reviews.approved_message')
        );
    }

    public function render(): View
    {
        return view('shopfolio::livewire.reviews.show');
    }
}
