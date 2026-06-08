<?php

namespace controllers;
use services\BundlesService;

class BundlesController
{
    private $bundlesService;

    public function __construct($router)
    {
        $this->bundlesService = new BundlesService();
        $router->get('/bundels', [$this, 'bundelsPage']);
        $router->get('/api/get_all_bundels', [$this, 'get_all_bundels']);


    }

    public function bundelsPage()
    {
        require __DIR__ . '/../public/bundels.php';
    }
    public function get_all_bundels() {

        header('Content-Type: application/json');

        $result = $this->bundlesService->get_all_bundels();
        if (empty($result)) {
            echo json_encode([
                "success" => false,
                "message" => "No data provided"
            ]);
            return;
        }


        echo json_encode([
            "success" => true,
            "message" => "Bundels retrieved successfully",
            "data" => $result
        ]);


        exit();
    }


}