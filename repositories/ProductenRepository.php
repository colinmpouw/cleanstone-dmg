<?php

namespace repositories;

use controllers\DatabaseController;

class ProductenRepository
{
    private DatabaseController $DB;

    public function __construct()
    {
        $this->DB = new DatabaseController();
    }

    public function getAllProducts(): array
    {
        $query = "
            SELECT 
                p.id,
                p.slug,
                p.name,
                p.price,
                p.sale_price,
                p.stock,
                COALESCE(p.image, (
                    SELECT COALESCE(NULLIF(pi.image, ''), pi.url)
                    FROM product_images pi
                    WHERE pi.product_id = p.id
                    ORDER BY pi.is_primary DESC, pi.id ASC
                    LIMIT 1
                )) as image,
                c.name as category_name,
                c.slug as category_slug,
                b.name as brand_name,
                COALESCE(ROUND(AVG(r.rating), 1), 0) as average_rating,
                COUNT(r.id) as review_count
            FROM products p
            LEFT JOIN brands b ON p.brand_id = b.id
            LEFT JOIN categories c ON p.category_id = c.id
            LEFT JOIN reviews r ON r.product_id = p.id
            GROUP BY p.id
            ORDER BY p.id DESC
        ";

        return $this->DB->read($query) ?: [];
    }

    public function getCategories(): array
    {
        $query = "SELECT id, name, slug FROM categories WHERE parent_id IS NULL ORDER BY name";
        return $this->DB->read($query) ?: [];
    }

    public function getBrands(): array
    {
        $query = "SELECT id, name FROM brands ORDER BY name";
        return $this->DB->read($query) ?: [];
    }

    public function getTopProducts(int $limit = 4): array
    {
        $query = "
            SELECT 
                p.id,
                p.slug,
                p.name,
                p.price,
                p.sale_price,
                p.stock,
                COALESCE(p.image, (
                    SELECT COALESCE(NULLIF(pi.image, ''), pi.url)
                    FROM product_images pi
                    WHERE pi.product_id = p.id
                    ORDER BY pi.is_primary DESC, pi.id ASC
                    LIMIT 1
                )) as image,
                c.name as category_name,
                c.slug as category_slug,
                b.name as brand_name,
                COALESCE(ROUND(AVG(r.rating), 1), 0) as average_rating,
                COUNT(r.id) as review_count
            FROM products p
            LEFT JOIN brands b ON p.brand_id = b.id
            LEFT JOIN categories c ON p.category_id = c.id
            LEFT JOIN reviews r ON r.product_id = p.id
            GROUP BY p.id
            ORDER BY p.id DESC
            LIMIT " . (int)$limit;

        return $this->DB->read($query) ?: [];
    }
    public function searchProductsForAi(string $searchTerm): array
    {
        $query = "
        SELECT * FROM products_full_details
        WHERE name LIKE ?
           OR category_name LIKE ?
           OR short_description LIKE ?
           OR description LIKE ?
        LIMIT 5
    ";

        $likeTerm = '%' . $searchTerm . '%';

        return $this->DB->read($query, [
            $likeTerm,
            $likeTerm,
            $likeTerm,
            $likeTerm
        ]) ?: [];
    }

    public function getTopProductsForAi(): array
    {
        return $this->DB->read("
        SELECT name, price FROM products_full_details
        WHERE avg_rating IS NOT NULL
        ORDER BY avg_rating DESC, review_count DESC
        LIMIT 5
    ") ?: [];
    }

}
