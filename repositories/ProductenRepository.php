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
        $query = "SELECT * FROM product_summary_view ORDER BY id DESC;";

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
             SELECT *
             FROM product_summary_view
             WHERE review_count > 0
             ORDER BY average_rating DESC, review_count DESC
            LIMIT 
            " . (int)$limit;

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
