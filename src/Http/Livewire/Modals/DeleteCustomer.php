<?php

namespace Shopfolio\Http\Livewire\Modals;

use Illuminate\Contracts\View\View;
use LivewireUI\Modal\ModalComponent;
use Shopfolio\Repositories\UserRepository;

class DeleteCustomer extends ModalComponent
{
    public int $customerId;

    public function mount(int $customerId)
    {
        $this->customerId = $customerId;
    }

    public function delete()
    {
        (new UserRepository())->getById($this->customerId)->delete();

        session()->flash('success', __('shopfolio::pages/customers.modal.success_message'));

        $this->redirectRoute('shopfolio.customers.index');
    }

    public static function modalMaxWidth(): string
    {
        return 'xl';
    }

    public function render(): View
    {
        return view('shopfolio::livewire.modals.delete-customer');
    }
}
