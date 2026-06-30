<?php
namespace adminControllers;
use adminServices\AdminCategoryService;

class adminCategoryController
{
    private AdminCategoryService $service;

    public function __construct($router)
    {
        $this->service = new AdminCategoryService();

        $router->get('/admin/categories-tags', [$this, 'ShowCategories']);
        $router->get('/api/admin/categories', [$this, 'getAll']);
        $router->post('/api/admin/categories', [$this, 'create']);
        $router->put('/api/admin/categories/{id}', [$this, 'update']);
        $router->delete('/api/admin/categories/{id}', [$this, 'delete']);
    }

    private function requireAdmin(): void
    {
        if (empty($_SESSION['user']['id']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: /admin/login');
            exit;
        }
    }

    public function ShowCategories(): void
    {
        $this->requireAdmin();
        require __DIR__ . '/../admin/adminCategories-Tags.php';
    }

    public function getAll(): void
    {
        $this->requireAdmin();
        header('Content-Type: application/json');
        $categories = $this->service->getAll();
        echo json_encode(['success' => true, 'data' => $categories]);
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
            'parent_id' => $data['parent_id'] ?: null,
            'name'      => trim($data['name']),
            'slug'      => trim($data['slug'] ?: strtolower(str_replace(' ', '-', $data['name']))),
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
            'parent_id' => $data['parent_id'] ?: null,
            'name'      => trim($data['name']),
            'slug'      => trim($data['slug'] ?: strtolower(str_replace(' ', '-', $data['name']))),
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
}