<?php

namespace adminRepositories;

use adminControllers\AdminDatabaseController;

class AdminProductsRepository
{
    private $DB;

    public function __construct()
    {
        $this->DB = new AdminDatabaseController();
    }

    public function getAllProducts(): array
    {
        $query = "SELECT * FROM product_summary_view ORDER BY id DESC;";
        return $this->DB->read($query) ?: [];
    }


    public function getProductById(int $id): ?array
    {
        $query = "
        SELECT *
        FROM products_full_details
        WHERE id = ?
        LIMIT 1
    ";

        $result = $this->DB->read($query, [$id]);
        return !empty($result) ? $result[0] : null;
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
    public function getTags()
    {
        $query = "SELECT id, name FROM tags ORDER BY name";
        return $this->DB->read($query) ?: [];
    }
}