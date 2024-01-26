<?php

namespace App\Models\Role\Consts;

class RoleConst
{
    public const ROLE_USER = 'user';
    public const ROLE_ADMIN = 'admin';
    public const ROLE_ROOT = 'root';

    public const GUARD_API = 'api';

    public const ROLES = [
        self::ROLE_USER,
        self::ROLE_ADMIN,
        self::ROLE_ROOT,
    ];
}
