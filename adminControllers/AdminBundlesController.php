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
        $router->get('/admin/bundel/bewerking/{id}', [$this, 'bundleEditPage']);
        $router->get('/admin/bundel/toevoegen', [$this, 'bundleAddPage']);
        $router->get('/api/admin/get_all_bundels', [$this, 'get_all_bundles']);
        $router->get('/api/admin/get_bundle/{bundle_id}', [$this, 'find_bundle']);
    }

    public function bundlesPage()
    {
        require_once __DIR__ . '/../admin/adminBundles.php';
        die();
    }

    public function bundleEditPage($id)
    {
        echo '<script>window.bundleId = ' . json_encode((int)$id) . ';</script>';
        require_once __DIR__ . '/../admin/adminEditBundle.php';
        die();
    }
    public function bundleAddPage()
    {
        require_once __DIR__ . '/../admin/adminAddBundle.php';
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
    public function find_bundle($bundle_id)
    {

        header('Content-Type: application/json');

        $result = $this->adminBundlesService->find_bundle($bundle_id);

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