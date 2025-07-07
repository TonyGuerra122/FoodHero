<?php

namespace App\Http\Controllers\Product;

use App\Http\Docs\Product\ProductDocs;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductController extends ProductDocs
{
    public function __construct(private readonly ProductService $service) {}

    public function getAll(): JsonResponse
    {
        $products = $this->service->fetchProducts();
        return response()->json($products);
    }

    public function getById(string $id): JsonResponse
    {
        $idParam = self::validateIdParameter($id);

        $product = $this->service->fetchProductById($idParam);
        if (!$product) {
            throw new NotFoundHttpException("Product with ID {$idParam} not found.");
        }

        return response()->json($product);
    }
}
