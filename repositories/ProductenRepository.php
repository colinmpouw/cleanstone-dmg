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
        $query = "SELECT * FROM products_full_details ORDER BY id DESC;";

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
            b.name as brand_name,
            ROUND(AVG(r.rating), 1) as average_rating,
            COUNT(r.id) as review_count
        FROM products p
        LEFT JOIN brands b ON p.brand_id = b.id
        LEFT JOIN reviews r ON r.product_id = p.id
        GROUP BY p.id, p.slug, p.name, p.price, p.sale_price, p.stock, p.image, b.name
        HAVING COUNT(r.id) > 0
        ORDER BY AVG(r.rating) DESC, COUNT(r.id) DESC
        LIMIT " . (int)$limit;

        return $this->DB->read($query) ?: [];
    }
    public function searchProductsForAi(string $searchTerm): array
    {
        $query = "
        SELECT DISTINCT id
        FROM products_full_details
        WHERE name LIKE ?
           OR category_name LIKE ?
           OR short_description LIKE ?
           OR description LIKE ?
        LIMIT 5
    ";

        $likeTerm = '%' . $searchTerm . '%';

        $ids = $this->DB->read($query, [
            $likeTerm,
            $likeTerm,
            $likeTerm,
            $likeTerm
        ]) ?: [];
        if (empty($ids)) {
            return [];
        }

        $idList = array_column($ids, 'id');

        $placeholders = implode(',', array_fill(0, count($idList), '?'));

        $rows = $this->DB->read("
        SELECT *
        FROM products_full_details
        WHERE id IN ($placeholders)
    ", $idList);

        return $rows ?: [];
    }


    public function getTopProductsForAi(): array
    {
        return $this->DB->read("
        SELECT 
            id,
            name,
            price,
            MAX(avg_rating) as avg_rating,
            MAX(review_count) as review_count
        FROM products_full_details
        WHERE avg_rating IS NOT NULL
        GROUP BY id, name, price
        ORDER BY avg_rating DESC, review_count DESC
        LIMIT 5
    ") ?: [];
    }

}
