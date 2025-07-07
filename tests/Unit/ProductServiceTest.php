<?php

namespace Tests\Unit;

use App\DTOs\ProductDTO;
use App\Services\ProductService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ProductServiceTest extends TestCase
{
    private ProductService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = app(ProductService::class);
    }

    public function testFetchProducts(): void
    {
        Cache::shouldReceive('remember')
            ->once()
            ->andReturn([
                [
                    'id' => 1,
                    'title' => 'Produto A',
                    'price' => 10.0,
                    'description' => 'Descrição A',
                    'category' => 'Categoria A',
                    'image' => 'image-a.jpg',
                    'rating' => ['rate' => 4.5, 'count' => 10],
                ]
            ]);

        $products = $this->service->fetchProducts();

        $this->assertIsArray($products);
        $this->assertNotEmpty($products);
        $this->assertInstanceOf(ProductDTO::class, $products[0]);
    }

    public function testFetchManyProductsByIds(): void
    {
        $data = [
            [
                'id' => 1,
                'title' => 'Produto A',
                'price' => 10.0,
                'description' => 'Descrição A',
                'category' => 'Categoria A',
                'image' => 'image-a.jpg',
                'rating' => ['rate' => 4.5, 'count' => 10],
            ],
            [
                'id' => 2,
                'title' => 'Produto B',
                'price' => 20.0,
                'description' => 'Descrição B',
                'category' => 'Categoria B',
                'image' => 'image-b.jpg',
                'rating' => ['rate' => 4.2, 'count' => 8],
            ],
        ];

        Cache::shouldReceive('remember')
            ->once()
            ->andReturn($data);

        $ids = [1, 2];
        $products = $this->service->fetchManyProductsByIds($ids);

        $this->assertIsArray($products);
        $this->assertNotEmpty($products);
        foreach ($products as $product) {
            $this->assertInstanceOf(ProductDTO::class, $product);
            $this->assertContains($product->id, $ids);
        }
    }

    public function testFetchProductById(): void
    {
        Cache::shouldReceive('remember')
            ->once()
            ->andReturn([
                [
                    'id' => 1,
                    'title' => 'Produto A',
                    'price' => 10.0,
                    'description' => 'Descrição A',
                    'category' => 'Categoria A',
                    'image' => 'image-a.jpg',
                    'rating' => ['rate' => 4.5, 'count' => 10],
                ]
            ]);

        $id = 1;
        $product = $this->service->fetchProductById($id);

        $this->assertInstanceOf(ProductDTO::class, $product);
        $this->assertEquals($id, $product->id);
    }
}
