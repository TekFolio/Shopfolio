<?php

namespace Shopfolio\Http\Livewire\Discounts;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Shopfolio\Http\Livewire\AbstractBaseComponent;
use Shopfolio\Models\Shop\Discount;
use Shopfolio\Models\Shop\DiscountDetail;
use Shopfolio\Models\Traits\HasPrice;
use Shopfolio\Models\User\User;

class Create extends AbstractBaseComponent
{
    use WithDiscountAttributes;
    use WithDiscountActions;
    use HasPrice;

    protected $listeners = ['addSelectedProducts', 'addSelectedCustomers'];

    public function mount()
    {
        $this->dateStart = now()->format('Y-m-d H:i');
    }

    public function rules(): array
    {
        return [
            'code' => 'required|unique:' . shopfolio_table('discounts'),
            'type' => 'required',
            'value' => 'required',
            'apply' => 'required',
            'dateStart' => 'required',
        ];
    }

    public function store()
    {
        if ($this->minRequired !== 'none') {
            $this->validate(['minRequiredValue' => 'required']);
        }

        if ($this->usage_number) {
            $this->validate(['usage_limit' => 'required|integer']);
        }

        $this->validate($this->rules());

        $discount = Discount::query()->create([
            'is_active' => $this->is_active,
            'code' => $this->code,
            'type' => $this->type,
            'value' => $this->value,
            'apply_to' => $this->apply,
            'min_required' => $this->minRequired,
            'min_required_value' => $this->minRequired !== 'none' ? $this->minRequiredValue : null,
            'eligibility' => $this->eligibility,
            'usage_limit' => $this->usage_limit ?? null,
            'usage_limit_per_user' => $this->usage_limit_per_user,
            'start_at' => Carbon::createFromFormat('Y-m-d H:i', $this->dateStart)->toDateTimeString(),
            'end_at' => $this->dateEnd ? Carbon::createFromFormat('Y-m-d H:i', $this->dateEnd)->toDateTimeString() : null,
        ]);

        if ($this->apply === 'products') {
            // Associate the discount to all the selected products.
            foreach ($this->selectedProducts as $productId) {
                DiscountDetail::query()->create([
                    'discount_id' => $discount->id,
                    'condition' => 'apply_to',
                    'discountable_type' => config('shopfolio.system.models.product'),
                    'discountable_id' => $productId,
                ]);
            }
        }

        if ($this->eligibility === 'customers') {
            // Associate the discount to all the selected users.
            foreach ($this->selectedCustomers as $customerId) {
                DiscountDetail::query()->create([
                    'discount_id' => $discount->id,
                    'condition' => 'eligibility',
                    'discountable_type' => config('auth.providers.users.model', User::class),
                    'discountable_id' => $customerId,
                ]);
            }
        }

        session()->flash('success', __('shopfolio::pages/discounts.add_message', ['code' => $discount->code]));

        $this->redirectRoute('shopfolio.discounts.index');
    }

    public function render(): View
    {
        return view('shopfolio::livewire.discounts.create');
    }
}
