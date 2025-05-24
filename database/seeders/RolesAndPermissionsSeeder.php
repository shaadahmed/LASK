<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'view_dashboard',
            'manage_users',
            'manage_roles',
            'manage_permissions',
            'view_reports',
            'manage_settings',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $superAdmin = Role::create(['name' => 'super-admin']);
        $admin = Role::create(['name' => 'admin']);
        $user = Role::create(['name' => 'user']);

        // Super Admin gets all permissions
        $superAdmin->givePermissionTo(Permission::all());

        // Admin permissions
        $admin->givePermissionTo([
            'view_dashboard',
            'manage_users',
            'view_reports',
            'manage_settings',
        ]);

        // User permissions
        $user->givePermissionTo([
            'view_dashboard',
        ]);

        // Create a super admin user
        $superAdminUser = User::where('email', 'superadmin@cms.com')->first();
        $superAdminUser->assignRole('super-admin');

        // Create an admin user
        $adminUser = User::where('email', 'admin@cms.com')->first();
        $adminUser->assignRole('admin');

        // Create a user
        $userUser = User::where('email', 'test@cms.com')->first();
        $userUser->assignRole('user');
    }
} 