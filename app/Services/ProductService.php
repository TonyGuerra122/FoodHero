<?php

namespace App\Services;

use App\DTOs\ProductDTO;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

final class ProductService
{
    private readonly string $API_URL;

    public function __construct()
    {
        $this->API_URL = env('PRODUCT_API_URL', 'https://api.example.com/products');
    }

    /**
     * Fetches a products list from the API.
     * 
     * @return ProductDTO[]
     */
    public function fetchProducts(): array
    {
        $data = $this->getCachedProductData();

        return collect($data)
            ->map(fn(array $item) => ProductDTO::fromArray($item))
            ->all();
    }

    /**
     * Fetches multiple products by their IDs from the API.
     * 
     * @param array $ids
     * @return ProductDTO[]
     */
    public function fetchManyProductsByIds(array $ids): array
    {
        $data = $this->getCachedProductData();

        return collect($data)
            ->filter(fn(array $item) => in_array($item['id'], $ids))
            ->map(fn(array $item) => ProductDTO::fromArray($item))
            ->all();
    }

    /**
     * Fetches a single product by ID from the API.
     * 
     * @param int $id
     * @return ProductDTO|null
     */
    public function fetchProductById(int $id): ?ProductDTO
    {
        $data = $this->getCachedProductData();

        $productData = collect($data)->firstWhere('id', $id);

        return $productData ? ProductDTO::fromArray($productData) : null;
    }

    /**
     * Recovers a product by its ID from the cache.
     * 
     * @return array
     */
    private function getCachedProductData(): array
    {
        return Cache::remember('products_cache', now()->addMinutes(10), function () {
            $response = Http::get($this->API_URL);
            return $response->successful() ? $response->json() : [];
        });
    }
}
