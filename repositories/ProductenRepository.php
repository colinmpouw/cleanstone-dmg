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
                p.stock,
                COALESCE(p.image, (
                    SELECT image
                    FROM product_images pi
                    WHERE pi.product_id = p.id
                    ORDER BY pi.id ASC
                    LIMIT 1
                )) as image,
                c.name as category_name,
                c.slug as category_slug,
                b.name as brand_name     
            FROM products p
            LEFT JOIN brands b ON p.brand_id = b.id
            LEFT JOIN categories c ON p.category_id = c.id
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
        $query = "SELECT * FROM get_top_products LIMIT " . (int)$limit;
        return $this->DB->read($query) ?: [];
    }
    public function searchProductsForAi(string $searchTerm): array
    {
        $query = "
        SELECT * FROM products_full_details
        WHERE name LIKE ?
        OR description LIKE ?
        LIMIT 10
    ";

        $likeTerm = '%' . $searchTerm . '%';

        return $this->DB->read($query, [
            $likeTerm,
            $likeTerm
        ]) ?: [];
    }
}
