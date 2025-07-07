<?php

namespace App\Http\Controllers;

use App\Enums\UserRoles;
use App\Http\Docs\AdminDocs;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AdminController extends AdminDocs
{
    public function listUsers(Request $request): JsonResponse
    {
        return response()->json([
            'message' => "List of users",
            self::paginate(User::query(), $request)
        ]);
    }

    public function deleteUser(string $id): JsonResponse
    {
        $idParam = self::validateIdParameter($id);

        $user = User::find($idParam);

        if (!$user) {
            throw new NotFoundHttpException("User not found");
        }

        $user->delete();
        return response()->json([
            'message' => "User deleted successfully"
        ]);
    }

    public function promoteUser(string $id): JsonResponse
    {
        $idParam = self::validateIdParameter($id);

        $user = User::find($idParam);

        if (!$user) {
            throw new NotFoundHttpException("User not found");
        }

        $user->role = UserRoles::ADMIN;
        $user->save();

        return response()->json([
            'message' => "User promoted to admin successfully"
        ]);
    }

    public function demoteUser(string $id): JsonResponse
    {
        $idParam = self::validateIdParameter($id);

        $user = User::find($idParam);

        if (!$user) {
            throw new NotFoundHttpException("User not found");
        }

        $user->role = UserRoles::DEFAULT;
        $user->save();

        return response()->json([
            'message' => "User demoted to user successfully"
        ]);
    }
}
