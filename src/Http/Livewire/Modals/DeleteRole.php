<?php

namespace Shopfolio\Http\Livewire\Modals;

use Illuminate\Contracts\View\View;
use LivewireUI\Modal\ModalComponent;
use Shopfolio\Models\User\Role;

class DeleteRole extends ModalComponent
{
    public int $roleId;

    public function mount(int $id)
    {
        $this->roleId = $id;
    }

    public function delete()
    {
        Role::query()->find($this->roleId)->delete();

        session()->flash('success', __('Role deleted successfully.'));

        $this->redirectRoute('shopfolio.settings.users');
    }

    public static function modalMaxWidth(): string
    {
        return 'lg';
    }

    public function render(): View
    {
        return view('shopfolio::livewire.modals.delete-role');
    }
}
