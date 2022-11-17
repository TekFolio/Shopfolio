<?php

namespace Shopfolio\Http\Livewire\Customers;

use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Shopfolio\Repositories\UserRepository;

class Browse extends Component
{
    public function render()
    {
        return view('shopfolio::livewire.customers.browse', [
            'total' => (new UserRepository())
                ->makeModel()
                ->whereHas('roles', function (Builder $query) {
                    $query->where('name', config('shopfolio.system.users.default_role'));
                })
                ->count(),
        ]);
    }
}
