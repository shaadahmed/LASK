<?php

namespace App\Services;

use App\Models\User;
use Spatie\Permission\Models\Permission;

class PermissionService
{
    public function assignToUser(User $user, Permission $permission): User
    {
        $user->givePermissionTo($permission);

        return $user->load('permissions');
    }

    public function removeFromUser(User $user, Permission $permission): User
    {
        $user->revokePermissionTo($permission);

        return $user->load('permissions');
    }
}
