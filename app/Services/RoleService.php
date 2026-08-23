<?php

namespace App\Services;

use App\Models\User;
use Spatie\Permission\Models\Role;

class RoleService
{
    public function assignPermissions(Role $role, array $permissionIds): Role
    {
        $role->syncPermissions($permissionIds);

        return $role->load('permissions');
    }

    public function removePermissions(Role $role, array $permissionIds): Role
    {
        $role->revokePermissionTo($permissionIds);

        return $role->load('permissions');
    }

    public function assignRoleToUser(User $user, Role $role): User
    {
        $user->assignRole($role);

        return $user->load('roles');
    }

    public function removeRoleFromUser(User $user, Role $role): User
    {
        $user->removeRole($role);

        return $user->load('roles');
    }
}
