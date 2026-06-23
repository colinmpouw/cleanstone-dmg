<?php

namespace adminControllers;

use adminServices\AdminProductsService;

class AdminProductsController
{
    private $service;
    public function __construct($router)
    {
        $this->service = new AdminProductsService();

        $router->get('/admin/producten', [$this, 'productsPage']);
        $router->get('/api/admin/get_all_products', [$this, 'get_all_products']);


    }
    public function productsPage(){
        require_once __DIR__ . '/../admin/adminProducts.php';
        die();
    }
    public function get_all_products()
    {
        $products = $this->service->getAllProducts();
        header('Content-Type: application/json');
        echo json_encode($products);
    }
}