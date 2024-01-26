<?php

namespace App\Models\Role;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends \Spatie\Permission\Models\Role
{
    use HasFactory;

    const USER = 'user';
    const ADMIN = 'admin';
    const ROOT = 'root';

    protected $keyType = 'string';
}
