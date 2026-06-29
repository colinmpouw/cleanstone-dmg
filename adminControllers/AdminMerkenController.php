<?php

namespace adminControllers;
use adminServices\AdminMerkenService;

class AdminMerkenController
{
    private AdminMerkenService $service;

    public function __construct($router)
    {
        $this->service = new AdminMerkenService();

        $router->get('/admin/merken', [$this, 'MerkenPage']);
        $router->get('/api/admin/merken', [$this, 'getAll']);
        $router->post('/api/admin/merken', [$this, 'create']);
        $router->put('/api/admin/merken/{id}', [$this, 'update']);
        $router->delete('/api/admin/merken/{id}', [$this, 'delete']);
        $router->post('/api/admin/merken/upload-logo', [$this, 'uploadLogo']);
    }

    private function requireAdmin(): void
    {
        if (empty($_SESSION['user']['id']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: /admin/login');
            exit;
        }
    }

    public function MerkenPage(): void
    {
        $this->requireAdmin();
        require_once __DIR__ . '/../admin/adminMerken.php';
    }

    public function getAll(): void
    {
        $this->requireAdmin();
        header('Content-Type: application/json');
        $merken = $this->service->getAll();
        echo json_encode(['success' => true, 'data' => $merken, 'count' => count($merken)]);
        exit;
    }

    public function create(): void
    {
        $this->requireAdmin();
        header('Content-Type: application/json');

        $data = json_decode(file_get_contents('php://input'), true);

        if (empty($data['name'])) {
            echo json_encode(['success' => false, 'message' => 'Naam is verplicht']);
            return;
        }

        $id = $this->service->create([
            'name'        => trim($data['name']),
            'discription' => trim($data['discription'] ?? ''),
            'logo'        => trim($data['logo'] ?? ''),
        ]);

        echo json_encode(['success' => true, 'id' => $id]);
        exit;
    }

    public function update(string $id): void
    {
        $this->requireAdmin();
        header('Content-Type: application/json');

        $data    = json_decode(file_get_contents('php://input'), true);
        $success = $this->service->update((int)$id, [
            'name'        => trim($data['name']),
            'discription' => trim($data['discription'] ?? ''),
            'logo'        => trim($data['logo'] ?? ''),
        ]);

        echo json_encode(['success' => $success]);
        exit;
    }

    public function delete(string $id): void
    {
        $this->requireAdmin();
        header('Content-Type: application/json');
        $success = $this->service->delete((int)$id);
        echo json_encode(['success' => $success]);
        exit;
    }

    public function uploadLogo(): void
    {
        $this->requireAdmin();
        header('Content-Type: application/json');

        if (empty($_FILES['logo'])) {
            echo json_encode(['success' => false, 'message' => 'Geen bestand']);
            return;
        }

        $file    = $_FILES['logo'];
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'svg'];
        $ext     = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            echo json_encode(['success' => false, 'message' => 'Alleen JPG, PNG, WEBP of SVG']);
            return;
        }

        if ($file['size'] > 2 * 1024 * 1024) {
            echo json_encode(['success' => false, 'message' => 'Bestand mag max 2MB zijn']);
            return;
        }

        $filename  = uniqid('brand_') . '.' . $ext;
        $uploadDir = __DIR__ . '/../uploads/brands/';

        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

        if (!move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
            echo json_encode(['success' => false, 'message' => 'Upload mislukt']);
            return;
        }

        echo json_encode(['success' => true, 'filename' => $filename]);
        exit;
    }
}