<?php

namespace adminControllers;

use adminServices\AdminBundlesService;

class AdminBundlesController
{
    private $adminBundlesService;

    public function __construct($router)
    {
        $this->adminBundlesService = new AdminBundlesService();
        $router->get('/admin/bundels', [$this, 'bundlesPage']);
        $router->get('/api/get_all_bundels', [$this, 'get_all_bundles']);

    }
    public function bundlesPage(){
        require_once __DIR__ . '/../admin/adminBundles.php';
        die();
    }
    public function get_all_bundles()
    {

        header('Content-Type: application/json');

        $result = $this->adminBundlesService->get_all_bundles();
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