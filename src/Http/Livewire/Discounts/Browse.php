<?php

namespace Shopfolio\Http\Livewire\Discounts;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;
use Shopfolio\Models\Shop\Discount;

class Browse extends Component
{
    use WithPagination;

    public string $search = '';

    public ?string $isActive = null;

    public ?string $date = null;

    public function paginationView(): string
    {
        return 'shopfolio::livewire.wire-pagination-links';
    }

    public function resetActiveFilter()
    {
        $this->isActive = null;
    }

    public function render(): View
    {
        return view('shopfolio::livewire.discounts.browse', [
            'total' => Discount::query()->count(),
            'discounts' => Discount::query()->where('code', 'like', '%' . $this->search . '%')
                ->where(function (Builder $query) {
                    if ($this->isActive !== null) {
                        $query->where('is_active', (bool) ($this->isActive));
                    }

                    if ($this->date !== null) {
                        $query->whereDate('start_at', $this->date)
                            ->orWhereDate('end_at', $this->date);
                    }
                })
                ->orderBy('created_at')
                ->paginate(8),
        ]);
    }
}
