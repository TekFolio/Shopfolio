<?php

namespace Shopfolio\Http\Livewire\Discounts;

use Carbon\Carbon;
use Shopfolio\Repositories\Ecommerce\ProductRepository;
use Shopfolio\Repositories\UserRepository;

trait WithDiscountActions
{
    public function isEmpty(): bool
    {
        if (
            ! $this->code &&
            ! $this->minRequiredValue &&
            ! $this->value &&
            ! $this->usage_limit
        ) {
            return true;
        }

        return false;
    }

    public function getProductSize(): string
    {
        if (count($this->selectedProducts) === 0) {
            return strtolower(__('shopfolio::layout.sidebar.products'));
        }

        if (count($this->selectedProducts) === 1) {
            return $this->products->first()->name;
        }

        if (count($this->selectedProducts) > 1) {
            return __('shopfolio::messages.count.products', ['count' => count($this->selectedProducts)]);
        }
    }

    public function getCustomSize(): ?string
    {
        if (count($this->selectedCustomers) === 0 || $this->eligibility === 'everyone') {
            return __('shopfolio::messages.everyone');
        }

        if (count($this->selectedCustomers) === 1) {
            return __('shopfolio::messages.for_name', ['name' => $this->customers->first()->first_name]);
        }

        if (count($this->selectedCustomers) > 1) {
            return __('shopfolio::messages.count.customers', ['count' => count($this->selectedCustomers)]);
        }

        return null;
    }

    public function getDateWord(): ?string
    {
        $today = Carbon::today();
        $startDate = new Carbon($this->dateStart);
        $endDate = new Carbon($this->dateEnd);

        if ($today->equalTo($startDate) && $today->equalTo($endDate) && $this->dateEnd !== null) {
            return __('shopfolio::pages/discounts.active_today');
        }

        if ($today->equalTo($startDate) && $this->dateEnd === null) {
            return __('shopfolio::pages/discounts.active_from_today');
        }

        if ($today->notEqualTo($startDate) && $this->dateEnd === null) {
            return __('shopfolio::pages/discounts.active_from', ['date' => $startDate->format('d M')]);
        }

        if ($today->notEqualTo($startDate) && $startDate->equalTo($endDate)) {
            return __('shopfolio::pages/discounts.active_date', ['date' => $startDate->format('d M')]);
        }

        if ($startDate->notEqualTo($endDate) && $startDate->lessThan($endDate) && $this->dateEnd !== null) {
            return __('shopfolio::pages/discounts.active_from_to', [
                'start' => $startDate->format('d M'),
                'end' => $endDate->format('d M'),
            ]);
        }

        if ($startDate->greaterThan($endDate) && $this->dateEnd !== null) {
            $this->dateEnd = Carbon::createFromFormat('Y-m-d H:i', $this->dateStart)->toDateString();

            return __('shopfolio::pages/discounts.active_date', ['date' => $startDate->format('d M')]);
        }

        return null;
    }

    public function getUsageLimitMessage(): ?string
    {
        if ($this->usage_number && $this->usage_limit !== null && (int) $this->usage_limit > 0) {
            $message = trans_choice('shopfolio::messages.discount_use', $this->usage_limit, ['count' => $this->usage_limit]);
            $message .= $this->usage_limit_per_user ? ', ' . __('shopfolio::pages/discounts.one_per_customer') : '';

            return $message;
        }

        if ($this->usage_limit_per_user && ! $this->usage_number) {
            return ucfirst(__('shopfolio::pages/discounts.one_per_customer'));
        }

        return null;
    }

    public function removeProduct(int $id): void
    {
        foreach (array_keys($this->selectedProducts, $id) as $key) {
            unset($this->selectedProducts[$key]);
        }

        $this->products = (new ProductRepository())
            ->makeModel()
            ->whereIn('id', $this->selectedProducts)
            ->get();
    }

    public function removeCustomer(int $id): void
    {
        foreach (array_keys($this->selectedCustomers, $id) as $key) {
            unset($this->selectedCustomers[$key]);
        }

        $this->customers = (new  UserRepository())
            ->makeModel()
            ->whereIn('id', $this->selectedCustomers)
            ->get();
    }

    public function addSelectedProducts(array $selectedProducts): void
    {
        if (count($this->selectedProducts) > 0) {
            $this->selectedProducts = array_merge($this->selectedProducts, $selectedProducts);
        } else {
            $this->selectedProducts = $selectedProducts;
        }

        $this->products = (new ProductRepository())
            ->makeModel()
            ->whereIn('id', $this->selectedProducts)
            ->get();
    }

    public function addSelectedCustomers(array $selectedCustomers): void
    {
        if (count($selectedCustomers) > 0) {
            $this->selectedCustomers = array_merge($this->selectedCustomers, $selectedCustomers);
        } else {
            $this->selectedCustomers = $selectedCustomers;
        }

        $this->customers = (new UserRepository())
            ->makeModel()
            ->whereIn('id', $this->selectedCustomers)
            ->get();
    }
}
