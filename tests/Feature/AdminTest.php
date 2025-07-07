<?php

namespace Tests\Feature;

use App\Enums\UserRoles;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    public function testAdminCanListUsers(): void
    {
        $admin = User::factory()->create(['role' => UserRoles::ADMIN]);

        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $user3 = User::factory()->create();

        Sanctum::actingAs($admin);

        $response = $this->getJson('/api/admin/users');
        $response->assertOk();
        $response->assertJsonCount(4, 'data');
        $response->assertJsonFragment([
            'id' => $user1->id,
            'name' => $user1->name,
            'email' => $user1->email,
            'role' => $user1->role,
            'created_at' => $user1->created_at,
            'updated_at' => $user1->updated_at
        ]);
        $response->assertJsonFragment([
            'id' => $user2->id,
            'name' => $user2->name,
            'email' => $user2->email,
            'role' => $user2->role,
            'created_at' => $user2->created_at,
            'updated_at' => $user2->updated_at
        ]);
        $response->assertJsonFragment([
            'id' => $user3->id,
            'name' => $user3->name,
            'email' => $user3->email,
            'role' => $user3->role,
            'created_at' => $user3->created_at,
            'updated_at' => $user3->updated_at
        ]);
    }

    public function testAdminCanDeleteUser(): void
    {
        $admin = User::factory()->create(['role' => UserRoles::ADMIN]);
        $user = User::factory()->create();

        Sanctum::actingAs($admin);

        $response = $this->deleteJson("/api/admin/users/{$user->id}");
        $response->assertNoContent();

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function testAdminCanPromoteUserToAdmin(): void
    {
        $admin = User::factory()->create(['role' => UserRoles::ADMIN]);
        $user = User::factory()->create(['role' => UserRoles::DEFAULT]);

        Sanctum::actingAs($admin);

        $response = $this->putJson("/api/admin/users/{$user->id}/promote");
        $response->assertOk();
        $response->assertJsonFragment([
            'message' => "User promoted to admin successfully"
        ]);

        $user->refresh();
        $this->assertEquals(UserRoles::ADMIN, $user->role);
    }

    public function testAdminCanDemoteUserToDefault(): void
    {
        $admin = User::factory()->create(['role' => UserRoles::ADMIN]);
        $user = User::factory()->create(['role' => UserRoles::ADMIN]);

        Sanctum::actingAs($admin);

        $response = $this->putJson("/api/admin/users/{$user->id}/demote");
        $response->assertOk();
        $response->assertJsonFragment([
            'message' => "User demoted to user successfully"
        ]);

        $user->refresh();
        $this->assertEquals(UserRoles::DEFAULT, $user->role);
    }
}
