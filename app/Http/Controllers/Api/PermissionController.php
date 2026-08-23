<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionRequest;
use App\Models\User;
use App\Services\PermissionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __construct(
        private readonly PermissionService $permissionService,
    ) {}

    public function index(): JsonResponse
    {
        return response()->json(Permission::all());
    }

    public function store(PermissionRequest $request): JsonResponse
    {
        $permission = Permission::create($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Permission created successfully',
            'data' => $permission,
        ], 201);
    }

    public function show(Permission $permission): JsonResponse
    {
        return response()->json($permission);
    }

    public function update(PermissionRequest $request, Permission $permission): JsonResponse
    {
        $permission->update($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Permission updated successfully',
            'data' => $permission,
        ]);
    }

    public function destroy(Permission $permission): JsonResponse
    {
        $permission->delete();

        return response()->json(['message' => 'Permission deleted successfully']);
    }

    public function assignPermissionToUser(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'permission_id' => ['required', 'exists:permissions,id'],
        ]);

        $user = User::findOrFail($validated['user_id']);
        $permission = Permission::findOrFail($validated['permission_id']);

        $this->permissionService->assignToUser($user, $permission);

        return response()->json(['message' => 'Permission assigned to user successfully']);
    }

    public function removePermissionFromUser(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'permission_id' => ['required', 'exists:permissions,id'],
        ]);

        $user = User::findOrFail($validated['user_id']);
        $permission = Permission::findOrFail($validated['permission_id']);

        $this->permissionService->removeFromUser($user, $permission);

        return response()->json(['message' => 'Permission removed from user successfully']);
    }

    public function getUserPermissions(User $user): JsonResponse
    {
        return response()->json($user->load('permissions')->permissions);
    }
}
