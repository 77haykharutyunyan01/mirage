<?php

namespace App\Console\Commands\OneTimeCommands;

use App\Models\Permission\Consts\PermissionConst;
use App\Models\Permission\Permission;
use App\Models\Role\Consts\RoleConst;
use App\Models\Role\Role;
use Exception;
use Illuminate\Console\Command;

class FillRoleAndPermissionsCommand extends Command
{
    protected $signature = 'role-permissions:fill';

    protected $description = 'Fill role-permissions';

    protected array $rolesData;
    protected array $permissionsData;

    public function handle(): bool {
        $currentRoles = Role::query()
            ->whereIn('name',RoleConst::ROLES)
            ->get()
            ->pluck('name');

        $currentPermissions = Permission::query()
            ->whereIn('name',PermissionConst::PERMISSIONS)
            ->get()
            ->pluck('name');

        $allRoles = collect(RoleConst::ROLES);
        $allPermissions = collect(PermissionConst::PERMISSIONS);

        $diffRoles = $allRoles->diff($currentRoles);
        $diffPermissions = $allPermissions->diff($currentPermissions);

        if ($diffRoles->isNotEmpty()) {
            foreach ($diffRoles as $role) {
                $this->rolesData[] = [
                    'name' => $role,
                    'guard_name' => RoleConst::GUARD_API,
                ];
            }

            if (!Role::query()->insert($this->rolesData)) {
                throw new Exception();
            }
        }

        if ($diffPermissions->isNotEmpty()) {
            foreach ($diffPermissions as $permission) {
                $this->permissionsData[] = [
                    'name' => $permission,
                    'guard_name' => PermissionConst::GUARD_API,
                ];
            }

            if (!Permission::query()->insert($this->permissionsData)) {
                throw new Exception();
            }
        }

        $roles = Role::query()->get();
        $permissions = Permission::query()->get();

        foreach ($roles as $role) {
            $permission = match ($role->name) {
                RoleConst::ROLE_USER => $permissions
                    ->whereIn('name', PermissionConst::USER_PERMISSIONS),
                RoleConst::ROLE_ADMIN => $permissions
                    ->whereIn('name', PermissionConst::ADMIN_PERMISSIONS),
                RoleConst::ROLE_ROOT => $permissions
                    ->whereIn('name', PermissionConst::ROOT_PERMISSIONS),
            };

            $role->syncPermissions($permission);
        }

        return true;
    }
}
