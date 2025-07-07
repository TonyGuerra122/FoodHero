<?php

namespace App\Http\Docs;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

abstract class AuthDocs extends Controller
{
    /**
     * @OA\Post(
     *     path="/auth/register",
     *     operationId="authRegister",
     *     tags={"Auth"},
     *     summary="Register a new user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", example="john@example.com"),
     *             @OA\Property(property="password", type="string", example="secret123")
     *         )
     *     ),
     *     @OA\Response(response=201, description="User registered successfully"),
     *     @OA\Response(response=422, description="Validation error"),
     *     @OA\Response(response=500, description="Internal server error")
     * )
     */
    abstract public function register(Request $request): JsonResponse;

    /**
     * @OA\Post(
     *     path="/auth/login",
     *     operationId="authLogin",
     *     tags={"Auth"},
     *     summary="Authenticate user and return token",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", example="john@example.com"),
     *             @OA\Property(property="password", type="string", example="secret123")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Login successful"),
     *     @OA\Response(response=401, description="Invalid credentials"),
     *     @OA\Response(response=500, description="Internal server error")
     * )
     */
    abstract public function login(Request $request): JsonResponse;

    /**
     * @OA\Post(
     *     path="/auth/logout",
     *     operationId="authLogout",
     *     tags={"Auth"},
     *     summary="Logout user",
     *     security={{"sanctum":{}}},
     *     @OA\Response(response=204, description="Logged out successfully"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=500, description="Internal server error")
     * )
     */
    abstract public function logout(Request $request): Response;

    /**
     * @OA\Get(
     *     path="/auth/me",
     *     operationId="authMe",
     *     tags={"Auth"},
     *     summary="Get current user",
     *     security={{"sanctum":{}}},
     *     @OA\Response(response=200, description="User data returned"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=500, description="Internal server error")
     * )
     */
    abstract public function me(Request $request): JsonResponse;

    /**
     * @OA\Delete(
     *     path="/auth/delete",
     *     operationId="authDelete",
     *     tags={"Auth"},
     *     summary="Delete authenticated user",
     *     security={{"sanctum":{}}},
     *     @OA\Response(response=204, description="User deleted successfully"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=500, description="Internal server error")
     * )
     */
    abstract public function delete(Request $request): Response;
}
