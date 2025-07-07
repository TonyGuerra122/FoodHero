<?php

namespace Tests\Feature\Product;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Override;

class ProductFeatureTest extends TestCase
{
    use RefreshDatabase;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();

        Cache::forget('products_cache');
    }

    public function testUserCanFetchProducts(): void
    {
        Http::fake([
            '*' => Http::response([
                [
                    'id' => 1,
                    'title' => 'Produto A',
                    'price' => 10.0,
                    'description' => 'Descrição A',
                    'category' => 'Categoria A',
                    'image' => 'image-a.jpg',
                    'rating' => [
                        'rate' => 4.5,
                        'count' => 10,
                    ],
                ],
                [
                    'id' => 2,
                    'title' => 'Produto B',
                    'price' => 20.0,
                    'description' => 'Descrição B',
                    'category' => 'Categoria B',
                    'image' => 'image-b.jpg',
                    'rating' => [
                        'rate' => 4.8,
                        'count' => 12,
                    ],
                ],
            ], 200),
        ]);


        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/products');

        $response
            ->assertOk()
            ->assertJsonStructure([
                '*' => ['id', 'title', 'price', 'description', 'category', 'image', 'rating'],
            ]);
    }

    public function testUserCanFetchSingleProduct(): void
    {
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

        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->getJson('/api/products/1/find');

        $response
            ->assertOk()
            ->assertJson([
                'id' => 1,
                'title' => 'Produto A',
                'price' => 10.0,
                'description' => 'Produto teste A',
                'category' => 'Categoria A',
                'image' => 'https://image-a.com',
                'rating' => ['rate' => 4.5, 'count' => 10]
            ]);
    }
}
