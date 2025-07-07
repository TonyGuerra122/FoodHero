<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

abstract class Controller
{
    protected static function paginate(Builder $query, Request $request): array
    {
        $perPage = (int) $request->query('per_page', 15);
        $page = (int) $request->query('page', 1);

        /** @var LengthAwarePaginator $pagination */
        $pagination = $query->paginate($perPage, ['*'], 'page', $page);

        return [
            'data' => $pagination->items(),
            'pagination' => [
                'total' => $pagination->total(),
                'count' => $pagination->count(),
                'per_page' => $pagination->perPage(),
                'current_page' => $pagination->currentPage(),
                'last_page' => $pagination->lastPage(),
                'has_more_pages' => $pagination->hasMorePages()
            ]
        ];
    }

    protected static function validateIdParameter(string $id): int
    {
        if (!is_numeric($id) || (int)$id <= 0) {
            throw new UnprocessableEntityHttpException(
                "Invalid ID parameter: {$id}. It must be a positive integer."
            );
        }
        return (int)$id;
    }
}
