<?php

namespace adminControllers;

class AdminProductsController
{
    public function __construct($router)
    {


        $router->get('/admin/products', [$this, 'productsPage']);

    }
    public function productsPage(){
        require_once __DIR__ . '/../admin/adminProducts.php';
        die();
    }
}