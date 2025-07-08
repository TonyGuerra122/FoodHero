<?php

namespace Database\Seeders;

use App\Models\Product\FavoriteProduct;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class FavoriteProductSeeder extends Seeder
{
    /**
     * Run the Favorite Product database seeds.
     */
    public function run(): void
    {
        $products = Http::get('https://fakestoreapi.com/products')->json();

        cache()->put('products_cache', $products, now()->addMinutes(10));

        foreach ($products as $product) {
            FavoriteProduct::factory()->create([
                'user_id' => 1,
                'api_id' => $product['id']
            ]);
        }
    }
}
