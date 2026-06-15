<?php

namespace repositories;

use controllers\DatabaseController;

class ProductViewRepository
{
    private DatabaseController $DB;

    public function __construct()
    {
        $this->DB = new DatabaseController();
    }

    public function getProductBySlug(string $slug): ?array
    {
        $query = "
            SELECT 
                p.id,
                p.slug,
                p.name,
                p.price,
                p.sale_price,
                p.stock,
                p.image,
                p.description,
                p.short_description,
                p.sku,
                c.name as category_name,
                c.slug as category_slug,
                b.name as brand_name,
                b.id as brand_id
            FROM products p
            LEFT JOIN brands b ON p.brand_id = b.id
            LEFT JOIN categories c ON p.category_id = c.id
            WHERE p.slug = ?
            LIMIT 1
        ";

        $result = $this->DB->read($query, [$slug]);
        return !empty($result) ? $result[0] : null;
    }

    public function getProductById(int $id): ?array
    {
        $query = "
            SELECT 
                p.id,
                p.slug,
                p.name,
                p.price,
                p.sale_price,
                p.stock,
                p.image,
                p.description,
                p.short_description,
                p.sku,
                c.name as category_name,
                c.slug as category_slug,
                b.name as brand_name,
                b.id as brand_id
            FROM products p
            LEFT JOIN brands b ON p.brand_id = b.id
            LEFT JOIN categories c ON p.category_id = c.id
            WHERE p.id = ?
            LIMIT 1
        ";

        $result = $this->DB->read($query, [$id]);
        return !empty($result) ? $result[0] : null;
    }

    public function getRelatedProducts(int $categoryId, int $excludeProductId, int $limit = 4): array
    {
        $query = "
            SELECT 
                p.id,
                p.slug,
                p.name,
                p.price,
                p.sale_price,
                p.stock,
                p.image,
                b.name as brand_name
            FROM products p
            LEFT JOIN brands b ON p.brand_id = b.id
            WHERE p.category_id = ? AND p.id != ?
            ORDER BY RAND()
            LIMIT ?
        ";

        return $this->DB->read($query, [$categoryId, $excludeProductId, $limit]) ?: [];
    }

    public function getProductImages(int $productId): array
    {
        $query = "
            SELECT 
                id,
                COALESCE(NULLIF(image, ''), url) AS image,
                alt_text,
                is_primary
            FROM product_images
            WHERE product_id = ?
            ORDER BY is_primary DESC, id ASC
        ";

        return $this->DB->read($query, [$productId]) ?: [];
    }

    public function getProductReviews(int $productId, int $limit = 5, int $offset = 0): array
    {
        $query = "
            SELECT 
                r.id,
                r.rating,
                r.review,
                COALESCE(u.username, CONCAT('Klant ', r.user_id)) as author,
                r.created_at
            FROM reviews r
            LEFT JOIN users u ON u.id = r.user_id
            WHERE r.product_id = ?
            ORDER BY r.created_at DESC
            LIMIT " . intval($limit) . " OFFSET " . intval($offset);

        return $this->DB->read($query, [$productId]) ?: [];
    }

    public function createProductReview(array $data): bool
    {
        $query = "
            INSERT INTO reviews (user_id, product_id, rating, review, created_at)
            VALUES (?, ?, ?, ?, NOW())
        ";

        return $this->DB->save($query, [
            $data['user_id'],
            $data['product_id'],
            $data['rating'],
            $data['review'],
        ]);
    }

    public function getAverageRating(int $productId): ?array
    {
        $query = "
            SELECT 
                AVG(rating) as average_rating,
                COUNT(*) as review_count
            FROM reviews
            WHERE product_id = ?
        ";

        $result = $this->DB->read($query, [$productId]);
        return !empty($result) ? $result[0] : null;
    }

    public function getProductSpecifications(int $productId): array
    {
        $query = "
            SELECT name, value
            FROM product_specifications
            WHERE product_id = ?
            ORDER BY display_order ASC
        ";

        return $this->DB->read($query, [$productId]) ?: [];
    }

    public function getProductFeatures(int $productId): array
    {
        $query = "
            SELECT feature
            FROM product_features
            WHERE product_id = ?
            ORDER BY display_order ASC
        ";

        return $this->DB->read($query, [$productId]) ?: [];
    }

    public function getProductInstructions(int $productId): array
    {
        $query = "
            SELECT step_number, instruction
            FROM product_instructions
            WHERE product_id = ?
            ORDER BY step_number ASC
        ";

        return $this->DB->read($query, [$productId]) ?: [];
    }
}
