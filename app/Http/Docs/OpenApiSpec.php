<?php

namespace App\Http\Docs;

/**
 * @OA\Info(
 *     title="FoodHero API",
 *     version="1.0.0",
 *     description="API para autenticação e gerenciamento de usuários"
 * )
 * 
 * @OA\Server(
 *     url="http://localhost:8000/api",
 *     description="API Local"
 * )
 * @OA\SecurityScheme(
 *     securityScheme="sanctum",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     description="Use o token JWT para autenticação. O token deve ser incluído no cabeçalho"
 * )
 */
final class OpenApiSpec
{
    // Esse arquivo existe apenas para documentação OpenAPI
}
