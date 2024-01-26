<?php

namespace App\Policies\User;

use App\Models\Role\Consts\RoleConst;
use App\Models\User\User;

class UserPolicy
{
    public function authorizeUser(User $user): bool
    {
        return $user->hasRole(RoleConst::ROLE_USER);
    }

    public function authorizeAdmin(User $user): bool
    {
        return $user->hasRole(RoleConst::ROLE_ADMIN);
    }

    public function authorizeRoot(User $user): bool
    {
        return $user->hasRole(RoleConst::ROLE_ROOT);
    }
}
