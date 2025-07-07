<?php

namespace Tests\Unit;

use App\DTOs\ProductDTO;
use App\Services\ProductService;
use Override;
use Tests\TestCase;

class ProductServiceTest extends TestCase
{
    private ProductService $service;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app(ProductService::class);
    }

    public function testFetchProducts(): void
    {
        $products = $this->service->fetchProducts();

        $this->assertIsArray($products);
        $this->assertNotEmpty($products);
        $this->assertInstanceOf(ProductDTO::class, $products[0]);
    }

    public function testFetchManyProductsByIds(): void
    {
        $ids = [1, 2, 3];
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
        $id = 1;
        $product = $this->service->fetchProductById($id);

        $this->assertInstanceOf(ProductDTO::class, $product);
        $this->assertEquals($id, $product->id);
    }
}
