<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanRegister(): void
    {
        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
        ];

        $response = $this->postJson('/api/auth/register', $data);

        $response->assertCreated();
        $response->assertJsonStructure([
            'message',
            'user' => [
                'id',
                'name',
                'email',
                'role',
                'created_at',
                'updated_at',
            ],
        ]);

        $this->assertDatabaseHas('users', [
            'email' => $data['email'],
            'name' => $data['name'],
            'role' => 'default',
        ]);

        $user = User::where('email', $data['email'])->first();
        $this->assertTrue(Hash::check($data['password'], $user->password));
    }

    public function testUserCanLogin(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password123'),
        ]);

        $data = [
            'email' => $user->email,
            'password' => 'password123',
        ];

        $response = $this->postJson('/api/auth/login', $data);

        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'user' => [
                'id',
                'name',
                'email',
                'role',
                'created_at',
                'updated_at',
            ],
            'token',
        ]);
    }

    public function testUserCannotLoginWithInvalidCredentials(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password123'),
        ]);

        $data = [
            'email' => $user->email,
            'password' => 'wrongpassword',
        ];

        $response = $this->postJson('/api/auth/login', $data);

        $response->assertUnauthorized();
        $response->assertJson(['message' => 'Invalid credentials.']);
    }

    public function testUserCanLogout(): void
    {
        $user = User::factory()->create();
        $plainToken = $user->createToken('auth_token')->plainTextToken;

        Sanctum::actingAs($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $plainToken)
            ->postJson('/api/auth/logout');

        $response->assertNoContent();

        [$id, $rawToken] = explode('|', $plainToken);

        $this->assertDatabaseMissing('personal_access_tokens', [
            'token' => hash('sha256', $rawToken),
        ]);
    }

    public function testUserCanGetProfile(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/auth/me');

        $response->assertOk();
        $response->assertJsonStructure([
            'user' => [
                'id',
                'name',
                'email',
                'role',
                'created_at',
                'updated_at',
            ],
        ]);
    }

    public function testUserCanDeleteAccount(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->deleteJson('/api/auth/delete');

        $response->assertNoContent();

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }
}
