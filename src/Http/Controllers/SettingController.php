<?php

namespace Shopfolio\Http\Controllers;

use Illuminate\Routing\Controller;
use Shopfolio\Models\User\Role;

class SettingController extends Controller
{
    public function initialize()
    {
        return view('shopfolio::pages.settings.initialize');
    }

    public function role(Role $role)
    {
        return view('shopfolio::pages.settings.management.role', compact('role'));
    }
}
