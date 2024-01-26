<?php

namespace App\Models\Permission\Consts;

class PermissionConst
{
    public const READ = 'read';
    public const WRITE = 'write';
    public const USE = 'use';

    public const GUARD_API = 'api';

    public const PERMISSIONS = [
        self::READ,
        self::WRITE,
        self::USE,
    ];

    public const USER_PERMISSIONS = [
        self::READ,
    ];

    public const ADMIN_PERMISSIONS = [
        self::READ,
        self::WRITE,
    ];

    public const ROOT_PERMISSIONS = [
        self::READ,
        self::WRITE,
        self::USE,
    ];
}
