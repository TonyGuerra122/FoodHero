<?php

namespace App\DTOs;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="ProductDTO",
 *     type="object",
 *     title="ProductDTO",
 *     description="Product Data Transfer Object",
 *     required={"id", "title", "price", "category", "image"}
 * )
 */
final class ProductDTO
{
    /**
     * @OA\Property(type="integer", example=1)
     */
    public readonly int $id;

    /**
     * @OA\Property(type="string", example="Sample Product")
     */
    public readonly string $title;

    /**
     * @OA\Property(type="number", format="float", example=99.99)
     */
    public readonly float $price;

    /**
     * @OA\Property(type="string", nullable=true, example="Product description")
     */
    public readonly ?string $description;

    /**
     * @OA\Property(type="string", example="Electronics")
     */
    public readonly string $category;

    /**
     * @OA\Property(type="string", example="https://example.com/image.png")
     */
    public readonly string $image;

    /**
     * @OA\Property(ref="#/components/schemas/RatingDTO", nullable=true)
     */
    public readonly ?RatingDTO $rating;

    public function __construct(
        int $id,
        string $title,
        float $price,
        ?string $description,
        string $category,
        string $image,
        ?RatingDTO $rating,
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->price = $price;
        $this->description = $description;
        $this->category = $category;
        $this->image = $image;
        $this->rating = $rating;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            title: $data['title'],
            price: $data['price'],
            description: $data['description'] ?? null,
            category: $data['category'],
            image: $data['image'],
            rating: isset($data['rating']) ? new RatingDTO(
                rate: $data['rating']['rate'],
                count: $data['rating']['count']
            ) : null
        );
    }
}

/**
 * @OA\Schema(
 *     schema="RatingDTO",
 *     type="object",
 *     title="RatingDTO",
 *     description="Product rating details",
 *     required={"rate", "count"}
 * )
 */
final class RatingDTO
{
    /**
     * @OA\Property(type="number", format="float", example=4.5)
     */
    public readonly float $rate;

    /**
     * @OA\Property(type="integer", example=100)
     */
    public readonly int $count;

    public function __construct(float $rate, int $count)
    {
        $this->rate = $rate;
        $this->count = $count;
    }
}
