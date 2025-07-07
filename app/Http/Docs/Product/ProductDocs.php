<?php

namespace App\Http\Docs\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

abstract class ProductDocs extends Controller
{
    /**
     * @OA\Get(
     *     path="/products",
     *     operationId="getAllProducts",
     *     tags={"Products"},
     *     summary="Get all products",
     *     security={{"sanctum":{}}},
     *     description="Fetches a list of all products from the API.",
     *     @OA\Response(response=200, description="List of products"),
     *     @OA\Response(response=500, description="Internal server error")
     * )
     */
    abstract public function getAll(): JsonResponse;

    /**
     * @OA\Get(
     *     path="/products/{id}/find",
     *     operationId="getProductById",
     *     tags={"Products"},
     *     summary="Get a product by ID",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID of the product to retrieve"
     *     ),
     *     description="Fetches a single product by its ID from the API.",
     *     @OA\Response(response=200, description="Product details"),
     *     @OA\Response(response=404, description="Product not found"),
     *     @OA\Response(response=500, description="Internal server error")
     * )
     */
    abstract public function getById(string $id): JsonResponse;
}
