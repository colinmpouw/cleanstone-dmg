<?php

namespace controllers;

use services\BundlesService;

class BundlesController
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
        echo '<script>window.bundle_id = ' . json_encode($bundle_id) . ';</script>';
        require __DIR__ . '/../public/bundle.php';
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
    public function find_bundle($bundle_id)
    {

        header('Content-Type: application/json');

        $result = $this->bundlesService->find_bundle($bundle_id);
        if (empty($result)) {
            echo json_encode([
                "success" => false,
                "message" => "No data provided"
            ]);
            return;
        }


        echo json_encode([
            "success" => true,
            "message" => "Bundle retrieved successfully",
            "data" => $result
        ]);


        exit();
    }


}