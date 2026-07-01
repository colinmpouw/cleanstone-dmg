<?php

namespace adminControllers;

use adminServices\AdminBundlesService;
use Exception;

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

        $router->post('/api/admin/upload_bundle_photo/{bundle_id}', [$this, 'upload_bundle_photo']);
        $router->put('/api/admin/update_bundle/{bundle_id}', [$this, 'update_bundle']);
        $router->post('/api/admin/create_bundle', [$this, 'create_bundle']);
    }
    private function requireAdmin(): void
    {
        if (empty($_SESSION['user']['id']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: /admin/login');
            exit;
        }
    }
    public function bundlesPage()
    {
        $this->requireAdmin();
        require_once __DIR__ . '/../admin/adminBundles.php';
        die();
    }

    public function bundleEditPage($id)
    {
        $this->requireAdmin();
        echo '<script>window.bundleId = ' . json_encode((int)$id) . ';</script>';
        require_once __DIR__ . '/../admin/adminEditBundle.php';
        die();
    }

    public function bundleAddPage()
    {
        $this->requireAdmin();
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

    public function upload_bundle_photo($bundle_id)
    {
        header('Content-Type: application/json');

        if (!isset($_FILES['photo'])) {
            http_response_code(400);
            echo json_encode([
                "success" => false,
                "message" => "No file uploaded"
            ]);
            exit;
        }

        try {
            $result = $this->adminBundlesService->uploadPhoto($bundle_id, $_FILES['photo']);

            echo json_encode([
                "success" => true,
                "message" => "Photo uploaded successfully",
                "data" => $result
            ]);
        } catch (Exception $e) {
            http_response_code(500);

            echo json_encode([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        }

        exit;
    }

    public function update_bundle($bundle_id)
    {
        header('Content-Type: application/json');

        try {
            $input = json_decode(file_get_contents('php://input'), true);

            if (!$input) {
                throw new Exception("Invalid JSON");
            }

            $result = $this->adminBundlesService->updateBundle($bundle_id, $input);

            echo json_encode([
                "success" => true,
                "message" => "Bundle updated successfully",
                "data" => $result
            ]);
        } catch (Exception $e) {
            http_response_code(400);

            echo json_encode([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        }

        exit;
    }

    public function create_bundle()
    {
        header('Content-Type: application/json');

        try {
            $input = $_POST;
            $photo = $_FILES['photo'] ?? null;

            if (empty($input)) {
                throw new Exception("Invalid form data");
            }

            if (isset($input['products']) && is_string($input['products'])) {
                $input['products'] = json_decode($input['products'], true) ?? [];
            }

            $result = $this->adminBundlesService->createBundle($input, $photo);

            echo json_encode([
                "success" => true,
                "message" => "Bundle created successfully",
                "data" => $result
            ]);
        } catch (Exception $e) {
            http_response_code(400);

            echo json_encode([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        }

        exit;
    }
}