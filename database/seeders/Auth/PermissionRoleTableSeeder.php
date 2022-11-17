<?php

namespace Database\Seeders\Auth;

use Illuminate\Database\Seeder;
use Shopfolio\Models\User\Permission;
use Shopfolio\Traits\Database\DisableForeignKeys;
use Spatie\Permission\Models\Role;

class PermissionRoleTableSeeder extends Seeder
{
    use DisableForeignKeys;

    /**
     * Run the database seed.
     */
    public function run()
    {
        $this->disableForeignKeys();

        $administrator = Role::query()->where('name', config('shopfolio.system.users.admin_role'))->firstOrFail();

        $permissions = Permission::all();

        $administrator->permissions()->sync($permissions->pluck('id')->all());

        $this->enableForeignKeys();
    }
}
