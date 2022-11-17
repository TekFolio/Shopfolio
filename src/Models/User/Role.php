<?php

namespace Shopfolio\Models\User;

use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    public function isAdmin(): bool
    {
        return $this->name === config('shopfolio.system.users.admin_role');
    }
}
