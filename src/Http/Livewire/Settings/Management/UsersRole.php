<?php

namespace Shopfolio\Http\Livewire\Settings\Management;

use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Shopfolio\Models\User\Role;
use Shopfolio\Repositories\UserRepository;
use WireUi\Traits\Actions;

class UsersRole extends Component
{
    use Actions;

    public Role $role;

    public function removeUser(int $id)
    {
        (new UserRepository())->getById($id)->delete();

        $this->dispatchBrowserEvent('user-removed');

        $this->notification()->success(__('Deleted'), __('Admin deleted successfully!'));
    }

    public function render()
    {
        $users = (new UserRepository())
            ->makeModel()
            ->whereHas('roles', function (Builder $query) {
                $query->where('name', $this->role->name);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('shopfolio::livewire.settings.management.users-role', compact('users'));
    }
}
