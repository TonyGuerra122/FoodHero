<?php

namespace Tests\Feature\Product;

use App\Models\Product\FavoriteProduct;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class FavoriteProductTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testFavoriteProductCanBeAdded(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        Cache::shouldReceive('remember')
            ->once()
            ->andReturn([
                [
                    'id' => 1,
                    'title' => 'Produto A',
                    'price' => 10.0,
                    'description' => 'Produto teste A',
                    'category' => 'Categoria A',
                    'image' => 'https://image-a.com',
                    'rating' => ['rate' => 4.5, 'count' => 10]
                ]
            ]);

        $response = $this->postJson('/api/products/favorites', [
            'api_id' => 1,
        ]);

        $response->assertCreated();
        $response->assertJsonStructure([
            'id',
            'api_id',
            'user_id',
            'created_at',
            'updated_at',
        ]);
    }

    public function testFavoriteProductCanBeRemoved(): void
    {
        $user = User::factory()->create();

        $favorite = FavoriteProduct::factory()->create([
            'user_id' => $user->id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->deleteJson('/api/products/favorites/' . $favorite->id);

        $response->assertNoContent();
    }
}
