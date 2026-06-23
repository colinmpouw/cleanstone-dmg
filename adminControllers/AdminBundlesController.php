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
        $router->get('/api/admin/get_all_bundels', [$this, 'get_all_bundles']);

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
    public function find_bundle($bundle_id, $bundle_name='')
    {

        header('Content-Type: application/json');

        $result = $this->bundlesService->find_bundle($bundle_id);

        if (!$result) {
            http_response_code(404);

            echo json_encode([
                "success" => false,
                "message" => "Bundle not found"
            ]);

            exit;
        }

        echo json_encode([
            "success" => true,
            "message" => "Bundle retrieved successfully",
            "data" => $result
        ]);


        exit();
    }

}