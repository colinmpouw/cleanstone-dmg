<?php

namespace repositories;
use controllers\DatabaseController;

class ReviewsRepository
{
    private DatabaseController $DB;

    public function __construct()
    {
        $this->DB = new DatabaseController();
    }

    public function getByUser(int $user_id): array
    {
        return $this->DB->read(
            "SELECT r.id, r.rating, r.review, r.created_at,
                    p.name as product_name, p.image as product_image,
                    p.id as product_id, p.slug as product_slug
             FROM reviews r
             LEFT JOIN products p ON p.id = r.product_id
             WHERE r.user_id = :user_id
             ORDER BY r.created_at DESC",
            ['user_id' => $user_id]
        ) ?: [];
    }

    public function update(int $id, int $user_id, int $rating, string $review): bool
    {
        return $this->DB->save(
            "UPDATE reviews SET rating = :rating, review = :review
             WHERE id = :id AND user_id = :user_id",
            ['rating' => $rating, 'review' => $review, 'id' => $id, 'user_id' => $user_id]
        );
    }

    public function delete(int $id, int $user_id): bool
    {
        return $this->DB->save(
            "DELETE FROM reviews WHERE id = :id AND user_id = :user_id",
            ['id' => $id, 'user_id' => $user_id]
        );
    }
}