<?php

namespace Shopfolio\Actions;

use Illuminate\Contracts\Auth\StatefulGuard;
use Shopfolio;

class ConfirmPassword
{
    /**
     * Confirm that the given password is valid for the given user.
     */
    public function __invoke(StatefulGuard $guard, $user, string $password): bool
    {
        return $guard->validate([
            Shopfolio::username() => $user->{Shopfolio::username()},
            'password' => $password,
        ]);
    }
}
