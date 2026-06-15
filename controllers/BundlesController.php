<?php

namespace controllers;

use services\BundlesService;

class   BundlesController
{
    private $bundlesService;

    public function __construct($router)
    {
        $this->bundlesService = new BundlesService();
        $router->get('/bundels', [$this, 'bundlesPage']);
        $router->get('/bundel/{bundle_id}/{slug}', [$this, 'bundlePage']);
        $router->get('/api/get_all_bundels', [$this, 'get_all_bundles']);
        $router->get('/api/find_bundle/{bundle_id}', [$this, 'find_bundle']);
        $router->get('/api/get_top_bundels', [$this, 'get_top_bundles']);
        $router->get('/api/find_bundles_by_similar/{bundle_id}/{bundle_name}', [$this, 'find_bundles_by_similar']);
    }

    public function get_top_bundles()
    {
        header('Content-Type: application/json');

        $result = $this->bundlesService->get_top_bundles();
        if (empty($result)) {
            echo json_encode(["success" => false, "message" => "No data provided"]);
            return;
        }

        echo json_encode([
            "success" => true,
            "message" => "Top bundels retrieved successfully",
            "data" => $result
        ]);
        exit();
    }

    public function bundlesPage()
    {
        require __DIR__ . '/../public/bundles.php';
    }

    public function bundlePage($bundle_id, $slug)
    {
        echo '<script>
                window.bundle_id = ' . json_encode($bundle_id) . ';
                window.bundle_name = ' . json_encode($slug) . ';
            </script>';
        require __DIR__ . '/../public/bundle.php';
    }

    public function find_bundles_by_similar($bundle_id, $bundle_name)
    {
        $bundle_name = str_replace('-', ' ', $bundle_name);
        header('Content-Type: application/json');

        $result = $this->bundlesService->find_bundles_by_similar($bundle_id, $bundle_name);
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

    public function get_all_bundles()
    {

        header('Content-Type: application/json');

        $result = $this->bundlesService->get_all_bundles();
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