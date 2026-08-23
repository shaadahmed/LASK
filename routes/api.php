<?php

use App\Http\Controllers\Api\NavigationController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\LogAllRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware([LogAllRequests::class, 'auth:sanctum'])->group(function () {
    Route::get('/user', fn (Request $request) => response()->json($request->user()));
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('roles/{role}/permissions', [RoleController::class, 'getPermissions']);
    Route::post('roles/{role}/permissions', [RoleController::class, 'assignPermissions']);
    Route::post('roles/assign-to-user', [RoleController::class, 'assignRoleToUser']);
    Route::post('roles/remove-from-user', [RoleController::class, 'removeRoleFromUser']);
    Route::get('users/{user}/roles', [RoleController::class, 'getUserRoles']);
    Route::apiResource('roles', RoleController::class);

    Route::post('permissions/assign-to-user', [PermissionController::class, 'assignPermissionToUser']);
    Route::post('permissions/remove-from-user', [PermissionController::class, 'removePermissionFromUser']);
    Route::get('users/{user}/permissions', [PermissionController::class, 'getUserPermissions']);
    Route::apiResource('permissions', PermissionController::class);

    Route::get('navigations/active', [NavigationController::class, 'active']);
    Route::apiResource('navigations', NavigationController::class);
});
