<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class PermissionTest extends TestCase
{
    private function authHeaders(): array
    {
        $user = User::where('email', 'superadmin@lask.com')->first();
        $token = $user->createToken('auth_token')->plainTextToken;

        return ['Authorization' => 'Bearer '.$token];
    }

    public function test_can_list_permissions(): void
    {
        $response = $this->withHeaders($this->authHeaders())
            ->getJson('/api/permissions');

        $response->assertOk();
        $this->assertNotEmpty($response->json());
    }

    public function test_can_create_permission(): void
    {
        $response = $this->withHeaders($this->authHeaders())
            ->postJson('/api/permissions', ['name' => 'edit_posts']);

        $response->assertCreated()
            ->assertJsonPath('data.name', 'edit_posts');

        $this->assertDatabaseHas('permissions', ['name' => 'edit_posts']);
    }

    public function test_can_show_permission(): void
    {
        $permission = Permission::where('name', 'view_dashboard')->first();

        $response = $this->withHeaders($this->authHeaders())
            ->getJson('/api/permissions/'.$permission->id);

        $response->assertOk()
            ->assertJsonPath('name', 'view_dashboard');
    }

    public function test_can_update_permission(): void
    {
        $permission = Permission::create(['name' => 'draft_posts']);

        $response = $this->withHeaders($this->authHeaders())
            ->putJson('/api/permissions/'.$permission->id, ['name' => 'publish_posts']);

        $response->assertOk()
            ->assertJsonPath('data.name', 'publish_posts');
    }

    public function test_can_delete_permission(): void
    {
        $permission = Permission::create(['name' => 'temporary_permission']);

        $this->withHeaders($this->authHeaders())
            ->deleteJson('/api/permissions/'.$permission->id)
            ->assertOk();

        $this->assertDatabaseMissing('permissions', ['name' => 'temporary_permission']);
    }

    public function test_can_assign_permission_to_user(): void
    {
        $user = User::where('email', 'developer@lask.com')->first();
        $permission = Permission::create(['name' => 'custom_access']);

        $response = $this->withHeaders($this->authHeaders())
            ->postJson('/api/permissions/assign-to-user', [
                'user_id' => $user->id,
                'permission_id' => $permission->id,
            ]);

        $response->assertOk();
        $this->assertTrue($user->fresh()->hasPermissionTo('custom_access'));
    }
}
