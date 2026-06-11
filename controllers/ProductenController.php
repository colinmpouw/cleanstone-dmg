<?php

namespace controllers;

use services\ProductenService;

class ProductenController
{
    private ProductenService $service;

    public function __construct(\Router $router)
    {
        $this->service = new ProductenService();
        $router->get('/producten', [$this, 'pageProducten']);
        $router->get('/api/get_all_products', [$this, 'get_all_products']);
        $router->get('/api/get_top_products', [$this, 'get_top_products']);

    }

    public function pageProducten()
    {
        $categories = $this->service->getCategories();
        $brands = $this->service->getBrands();

        require __DIR__ . '/../public/producten.php';
    }

    public function get_all_products()
    {
        $products = $this->service->getAllProducts();
        header('Content-Type: application/json');
        echo json_encode($products);
    }

    public function get_top_products()
    {
        header('Content-Type: application/json');
        $products = $this->service->getTopProducts();
        echo json_encode([
            "success" => true,
            "data" => $products
        ]);
        exit();
    }
}
