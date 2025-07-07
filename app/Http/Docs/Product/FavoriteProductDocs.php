<?php

namespace App\Http\Docs\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

abstract class FavoriteProductDocs extends Controller
{
    /**
     * @OA\Get(
     *     path="/products/favorites",
     *     summary="Get Favorite Products",
     *     security={{"sanctum":{}}},
     *     tags={"Products"},
     *     description="Retrieve a list of favorite products for the authenticated user.",
     *     operationId="getFavoriteProducts",
     *     @OA\Response(
     *         response=200,
     *         description="A list of favorite products.",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/ProductDTO")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized. User must be authenticated."
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error."
     *     ),
     * )
     */
    abstract public function index(Request $request): JsonResponse;

    /**
     * @OA\Get(
     *     path="/products/favorites/{id}",
     *     summary="Show Favorite Product",
     *     security={{"sanctum":{}}},
     *     tags={"Products"},
     *     description="Retrieve a specific favorite product by its ID for the authenticated user.",
     *     operationId="showFavoriteProduct",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="The ID of the favorite product to retrieve."
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Details of the favorite product.",
     *         @OA\JsonContent(
     *             type="object",
     *             ref="#/components/schemas/ProductDTO"
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found. The specified favorite product does not exist."
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized. User must be authenticated."
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error."
     *     )
     * )
     */
    abstract public function show(string $id): JsonResponse;

    /**
     * @OA\Post(
     *     path="/products/favorites",
     *     summary="Store Favorite Product",
     *     security={{"sanctum":{}}},
     *     tags={"Products"},
     *     description="Store a product as a favorite for the authenticated user.",
     *     operationId="storeFavoriteProduct",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"api_id"},
     *             @OA\Property(property="api_id", type="integer", description="The API ID of the product to favorite.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Product successfully added to favorites.",
     *         @OA\JsonContent(
     *             type="object",
     *             ref="#/components/schemas/ProductDTO"
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Bad request. Invalid input data."
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized. User must be authenticated."
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error."
     *     )
     * )
     */
    abstract public function store(Request $request): JsonResponse;

    /**
     * @OA\Delete(
     *     path="/products/favorites/{id}",
     *     summary="Destroy Favorite Product",
     *     security={{"sanctum":{}}},
     *     tags={"Products"},
     *     description="Remove a product from the authenticated user's favorites.",
     *     operationId="destroyFavoriteProduct",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="The ID of the favorite product to remove."
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Product successfully removed from favorites."
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found. The specified favorite product does not exist."
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized. User must be authenticated."
     *     ),
     *     @OA\Response(
     *         response=409,
     *         description="Conflict. The product is already in the user's favorites."
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error."
     *     )
     * )
     */
    abstract public function destroy(Request $request, string $id): Response;
}
