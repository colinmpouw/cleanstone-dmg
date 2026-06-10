<?php

namespace controllers;
use services\BrandsService;

class BrandsController
{
    private $brandsService;

    public function __construct($router)
    {
        $this->brandsService = new BrandsService();
        $router->get('/api/get_all_brands', [$this, 'get_all_brands']);
    }

    public function get_all_brands()
    {
        header('Content-Type: application/json');

        $result = $this->brandsService->get_all_brands();

        if (empty($result)) {
            echo json_encode(["success" => false, "message" => "No brands found"]);
            return;
        }

        echo json_encode([
            "success" => true,
            "data" => $result
        ]);
        exit();
    }
}