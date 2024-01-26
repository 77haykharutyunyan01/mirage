<?php

namespace App\Models\Permission;

use App\Traits\Helper\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends \Spatie\Permission\Models\Permission
{
    use HasFactory, Uuid;
}
