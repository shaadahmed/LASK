<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\TestCase;

class ApiAuthTest extends TestCase
{
    public function test_user_can_register(): void
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertCreated()
            ->assertJsonStructure(['access_token', 'token_type', 'user']);

        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    }

    public function test_user_can_login(): void
    {
        $response = $this->postJson('/api/login', [
            'email' => 'superadmin@lask.com',
            'password' => 'S.Admin.123',
        ]);

        $response->assertOk()
            ->assertJsonStructure(['access_token', 'token_type', 'user']);
    }

    public function test_login_fails_with_invalid_credentials(): void
    {
        $response = $this->postJson('/api/login', [
            'email' => 'superadmin@lask.com',
            'password' => 'wrong-password',
        ]);

        $response->assertUnauthorized();
    }

    public function test_user_can_logout(): void
    {
        $user = User::where('email', 'superadmin@lask.com')->first();
        $token = $user->createToken('auth_token')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer '.$token)
            ->postJson('/api/logout');

        $response->assertOk();
        $this->assertDatabaseMissing('personal_access_tokens', [
            'tokenable_id' => $user->id,
        ]);
    }

    public function test_login_invalidates_previous_tokens(): void
    {
        $user = User::where('email', 'superadmin@lask.com')->first();
        $oldToken = $user->createToken('auth_token')->plainTextToken;

        $this->postJson('/api/login', [
            'email' => 'superadmin@lask.com',
            'password' => 'S.Admin.123',
        ])->assertOk();

        $this->withHeader('Authorization', 'Bearer '.$oldToken)
            ->getJson('/api/user')
            ->assertUnauthorized();
    }
}
