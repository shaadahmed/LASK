<?php

namespace Tests\Feature\Api;

use App\Models\Navigation;
use App\Models\User;
use Tests\TestCase;

class NavigationTest extends TestCase
{
    private function authHeaders(): array
    {
        $user = User::where('email', 'superadmin@lask.com')->first();
        $token = $user->createToken('auth_token')->plainTextToken;

        return ['Authorization' => 'Bearer '.$token];
    }

    public function test_can_list_navigations(): void
    {
        Navigation::create([
            'name' => 'Dashboard',
            'path' => '/dashboard',
            'order' => 1,
            'is_active' => true,
            'is_hidden' => false,
        ]);

        $response = $this->withHeaders($this->authHeaders())
            ->getJson('/api/navigations');

        $response->assertOk();
        $this->assertCount(1, $response->json());
    }

    public function test_can_create_navigation(): void
    {
        $response = $this->withHeaders($this->authHeaders())
            ->postJson('/api/navigations', [
                'name' => 'Settings',
                'path' => '/settings',
                'order' => 2,
                'is_active' => true,
                'is_hidden' => false,
            ]);

        $response->assertCreated()
            ->assertJsonPath('data.name', 'Settings');

        $this->assertDatabaseHas('navigations', ['name' => 'Settings']);
    }

    public function test_can_show_navigation(): void
    {
        $navigation = Navigation::create([
            'name' => 'Reports',
            'path' => '/reports',
            'order' => 3,
            'is_active' => true,
            'is_hidden' => false,
        ]);

        $response = $this->withHeaders($this->authHeaders())
            ->getJson('/api/navigations/'.$navigation->id);

        $response->assertOk()
            ->assertJsonPath('name', 'Reports');
    }

    public function test_can_update_navigation(): void
    {
        $navigation = Navigation::create([
            'name' => 'Old Name',
            'path' => '/old',
            'order' => 4,
            'is_active' => true,
            'is_hidden' => false,
        ]);

        $response = $this->withHeaders($this->authHeaders())
            ->putJson('/api/navigations/'.$navigation->id, [
                'name' => 'New Name',
                'path' => '/new',
            ]);

        $response->assertOk()
            ->assertJsonPath('data.name', 'New Name');
    }

    public function test_can_delete_navigation(): void
    {
        $navigation = Navigation::create([
            'name' => 'Temporary',
            'path' => '/temp',
            'order' => 5,
            'is_active' => true,
            'is_hidden' => false,
        ]);

        $this->withHeaders($this->authHeaders())
            ->deleteJson('/api/navigations/'.$navigation->id)
            ->assertOk();

        $this->assertSoftDeleted('navigations', ['id' => $navigation->id]);
    }

    public function test_can_get_active_navigations(): void
    {
        Navigation::create([
            'name' => 'Visible',
            'path' => '/visible',
            'order' => 1,
            'is_active' => true,
            'is_hidden' => false,
        ]);

        Navigation::create([
            'name' => 'Hidden',
            'path' => '/hidden',
            'order' => 2,
            'is_active' => true,
            'is_hidden' => true,
        ]);

        $response = $this->withHeaders($this->authHeaders())
            ->getJson('/api/navigations/active');

        $response->assertOk();
        $this->assertCount(1, $response->json());
        $this->assertEquals('Visible', $response->json('0.name'));
    }
}
