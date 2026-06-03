<?php

namespace controllers;
use controllers\DatabaseController;

class ProductenController
{
    private DatabaseController $db;

    public function __construct(\Router $router)
    {
        $this->db = new DatabaseController();
        $router->get('/producten', [$this, 'pageProducten']);
    }

    public function pageProducten()
    {
        $products = $this->getProducts();
        $categories = $this->getCategories();
        $brands = $this->getBrands();
        
        require __DIR__ . '/../public/producten.php';
    }

    private function getProducts()
    {
        $query = "
            SELECT 
                p.id, 
                p.name, 
                p.price, 
                p.stock,
                b.name as brand_name
            FROM products p
            LEFT JOIN brands b ON p.brand_id = b.id
            ORDER BY p.id DESC
        ";
        
        return $this->db->read($query) ?: [];
    }

    private function getCategories()
    {
        $query = "SELECT id, name, slug FROM categories WHERE parent_id IS NULL ORDER BY name";
        return $this->db->read($query) ?: [];
    }

    private function getBrands()
    {
        $query = "SELECT id, name FROM brands ORDER BY name";
        return $this->db->read($query) ?: [];
    }
}