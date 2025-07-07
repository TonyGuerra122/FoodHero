<?php

namespace App\Http\Controllers\Product;

use App\Http\Docs\Product\FavoriteProductDocs;
use App\Models\Product\FavoriteProduct;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FavoriteProductController extends FavoriteProductDocs
{
    public function __construct(private readonly ProductService $productService) {}

    public function index(Request $request): JsonResponse
    {
        $favoriteIds = (array) FavoriteProduct::where('user_id', $request->user()->id)
            ->pluck('api_id')
            ->toArray();

        $products = $this->productService->fetchManyProductsByIds($favoriteIds);

        return response()->json($products);
    }

    public function show(string $id): JsonResponse
    {
        $idParam = self::validateIdParameter($id);

        $idParam = FavoriteProduct::where('id', $idParam)
            ->pluck('api_id')
            ->first();

        $product = $this->productService->fetchProductById($idParam);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json($product);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'api_id' => 'required|integer',
        ], [
            'api_id.required' => 'The API ID is required.',
            'api_id.integer' => 'The API ID must be an integer.',
        ]);

        if (!$this->productService->fetchProductById($data['api_id'])) {
            throw new NotFoundHttpException(
                'Product with ID ' . $data['api_id'] . ' not found in the external API.'
            );
        }

        $exists = FavoriteProduct::where('user_id', $request->user()->id)
            ->where('api_id', $data['api_id'])
            ->exists();

        if ($exists) {
            throw new ConflictHttpException(
                'Product with ID ' . $data['api_id'] . ' is already in your favorites.'
            );
        }

        $favoriteProduct = FavoriteProduct::create([
            'api_id' => $data['api_id'],
            'user_id' => $request->user()->id,
        ]);

        return response()->json($favoriteProduct, 201);
    }

    public function destroy(Request $request, string $id): JsonResponse
    {
        $idParam = self::validateIdParameter($id);

        $favoriteProduct = FavoriteProduct::where('user_id', $request->user()->id)
            ->where('id', $idParam)
            ->first();

        if (!$favoriteProduct) {
            return response()->json(['message' => 'Favorite product not found'], 404);
        }

        $favoriteProduct->delete();

        return response()->json(['message' => 'Favorite product removed successfully']);
    }
}
