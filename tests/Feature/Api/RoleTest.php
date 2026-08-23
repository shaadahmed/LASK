<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RoleTest extends TestCase
{
    private function authHeaders(): array
    {
        $user = User::where('email', 'superadmin@lask.com')->first();
        $token = $user->createToken('auth_token')->plainTextToken;

        return ['Authorization' => 'Bearer '.$token];
    }

    public function test_can_list_roles(): void
    {
        $response = $this->withHeaders($this->authHeaders())
            ->getJson('/api/roles');

        $response->assertOk();
        $this->assertNotEmpty($response->json());
    }

    public function test_can_create_role(): void
    {
        $response = $this->withHeaders($this->authHeaders())
            ->postJson('/api/roles', ['name' => 'editor']);

        $response->assertCreated()
            ->assertJsonPath('data.name', 'editor');

        $this->assertDatabaseHas('roles', ['name' => 'editor']);
    }

    public function test_can_show_role(): void
    {
        $role = Role::where('name', 'admin')->first();

        $response = $this->withHeaders($this->authHeaders())
            ->getJson('/api/roles/'.$role->id);

        $response->assertOk()
            ->assertJsonPath('name', 'admin');
    }

    public function test_can_update_role(): void
    {
        $role = Role::create(['name' => 'moderator']);

        $response = $this->withHeaders($this->authHeaders())
            ->putJson('/api/roles/'.$role->id, ['name' => 'moderator-updated']);

        $response->assertOk()
            ->assertJsonPath('data.name', 'moderator-updated');
    }

    public function test_can_delete_role(): void
    {
        $role = Role::create(['name' => 'temporary']);

        $this->withHeaders($this->authHeaders())
            ->deleteJson('/api/roles/'.$role->id)
            ->assertOk();

        $this->assertDatabaseMissing('roles', ['name' => 'temporary']);
    }

    public function test_can_assign_permissions_to_role(): void
    {
        $role = Role::create(['name' => 'content-manager']);
        $permission = Permission::where('name', 'view_dashboard')->first();

        $response = $this->withHeaders($this->authHeaders())
            ->postJson('/api/roles/'.$role->id.'/permissions', [
                'permission_ids' => [$permission->id],
            ]);

        $response->assertOk();
        $this->assertTrue($role->fresh()->hasPermissionTo('view_dashboard'));
    }
}
