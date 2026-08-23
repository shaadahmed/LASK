<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Models\User;
use App\Services\RoleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct(
        private readonly RoleService $roleService,
    ) {}

    public function index(): JsonResponse
    {
        return response()->json(Role::with('permissions')->get());
    }

    public function store(RoleRequest $request): JsonResponse
    {
        $role = Role::create($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Role created successfully',
            'data' => $role,
        ], 201);
    }

    public function show(Role $role): JsonResponse
    {
        return response()->json($role->load('permissions'));
    }

    public function update(RoleRequest $request, Role $role): JsonResponse
    {
        $role->update($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Role updated successfully',
            'data' => $role,
        ]);
    }

    public function destroy(Role $role): JsonResponse
    {
        $role->delete();

        return response()->json(['message' => 'Role deleted successfully']);
    }

    public function assignPermissions(Request $request, Role $role): JsonResponse
    {
        $validated = $request->validate([
            'permission_ids' => ['required', 'array'],
            'permission_ids.*' => ['exists:permissions,id'],
        ]);

        $this->roleService->assignPermissions($role, $validated['permission_ids']);

        return response()->json(['message' => 'Permissions assigned successfully']);
    }

    public function removePermissions(Request $request, Role $role): JsonResponse
    {
        $validated = $request->validate([
            'permission_ids' => ['required', 'array'],
            'permission_ids.*' => ['exists:permissions,id'],
        ]);

        $this->roleService->removePermissions($role, $validated['permission_ids']);

        return response()->json(['message' => 'Permissions removed successfully']);
    }

    public function getPermissions(Role $role): JsonResponse
    {
        return response()->json($role->load('permissions')->permissions);
    }

    public function assignRoleToUser(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        $user = User::findOrFail($validated['user_id']);
        $role = Role::findOrFail($validated['role_id']);

        $this->roleService->assignRoleToUser($user, $role);

        return response()->json(['message' => 'Role assigned to user successfully']);
    }

    public function removeRoleFromUser(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        $user = User::findOrFail($validated['user_id']);
        $role = Role::findOrFail($validated['role_id']);

        $this->roleService->removeRoleFromUser($user, $role);

        return response()->json(['message' => 'Role removed from user successfully']);
    }

    public function getUserRoles(User $user): JsonResponse
    {
        return response()->json($user->load('roles')->roles);
    }
}
