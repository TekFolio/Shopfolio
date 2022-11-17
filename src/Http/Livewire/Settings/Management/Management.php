<?php

namespace Shopfolio\Http\Livewire\Settings\Management;

use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;
use Shopfolio\Models\User\Role;
use Shopfolio\Repositories\UserRepository;
use WireUi\Traits\Actions;

class Management extends Component
{
    use Actions;
    use WithPagination;

    protected $listeners = ['onRoleAdded' => '$refresh'];

    public function removeUser(int $id)
    {
        (new UserRepository())->getById($id)->delete();

        $this->dispatchBrowserEvent('user-removed');

        $this->notification()->success(__('Deleted'), __('Admin deleted successfully!'));
    }

    public function render()
    {
        return view('shopfolio::livewire.settings.management.index', [
            'roles' => Role::query()
                ->with('users')
                ->whereIn('name', [config('shopfolio.system.users.admin_role'), 'manager'])
                ->limit(3)
                ->orderBy('created_at')
                ->get(),
            'users' => (new UserRepository())
                ->makeModel()
                ->whereHas('roles', function (Builder $query) {
                    $query->where('name', '<>', config('shopfolio.system.users.default_role'));
                })
                ->orderBy('created_at', 'desc')
                ->paginate(3),
        ]);
    }
}
