<?php

namespace App\Http\Docs;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

abstract class AdminDocs extends Controller
{
    /**
     * @OA\Get(
     *     path="/admin/users",
     *     operationId="adminGetUsers",
     *     tags={"Admin"},
     *     summary="Get all users (admin only)",
     *     description="Requires the user to have the 'admin' role.",
     *     security={{"sanctum":{}}},
     *     @OA\Response(response=200, description="List of users"),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=403, description="Forbidden (not admin)"),
     *     @OA\Response(response=500, description="Internal server error")
     * )
     */
    abstract public function listUsers(Request $request): JsonResponse;

    /**
     * @OA\Delete(
     *     path="/admin/users/{id}",
     *     operationId="adminDeleteUser",
     *     tags={"Admin"},
     *     summary="Delete a user (admin only)",
     *     description="Requires the user to have the 'admin' role.",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID of the user to delete"
     *     ),
     *     @OA\Response(response=200, description="User deleted successfully"),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=403, description="Forbidden (not admin)"),
     *     @OA\Response(response=404, description="User not found"),
     *     @OA\Response(response=500, description="Internal server error")
     * )
     */
    abstract public function deleteUser(string $id): Response;

    /**
     * @OA\Put(
     *     path="/admin/users/{id}/promote",
     *     operationId="adminPromoteUser",
     *     tags={"Admin"},
     *     summary="Promote a user to admin (admin only)",
     *     description="Requires the user to have the 'admin' role.",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID of the user to promote"
     *     ),
     *     @OA\Response(response=204, description="User promoted successfully"),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=403, description="Forbidden (not admin)"),
     *     @OA\Response(response=404, description="User not found"),
     *     @OA\Response(response=500, description="Internal server error")
     * )    
     */
    abstract public function promoteUser(string $id): JsonResponse;

    /**
     * @OA\Put(
     *     path="/admin/users/{id}/demote",
     *     operationId="adminDemoteUser",
     *     tags={"Admin"},
     *     summary="Demote a user from admin (admin only)",
     *     description="Requires the user to have the 'admin' role.",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *        @OA\Schema(type="integer"),
     *        description="ID of the user to demote"
     *    ),
     *   @OA\Response(response=200, description="User demoted successfully"),
     *   @OA\Response(response=401, description="Unauthorized"),
     *  @OA\Response(response=403, description="Forbidden (not admin)"),
     *  @OA\Response(response=404, description="User not found"),
     * @OA\Response(response=500, description="Internal server error")
     * )
     */
    abstract public function demoteUser(string $id): JsonResponse;
}
