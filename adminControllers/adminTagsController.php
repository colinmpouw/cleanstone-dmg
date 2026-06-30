<?php
namespace adminControllers;
use adminServices\AdminTagsService;

class adminTagsController
{
    private AdminTagsService $service;

    public function __construct($router)
    {
        $this->service = new AdminTagsService();

        $router->get('/api/admin/tags', [$this, 'getAll']);
        $router->post('/api/admin/tags', [$this, 'create']);
        $router->put('/api/admin/tags/{id}', [$this, 'update']);
        $router->delete('/api/admin/tags/{id}', [$this, 'delete']);
    }

    private function requireAdmin(): void
    {
        if (empty($_SESSION['user']['id']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: /admin/login');
            exit;
        }
    }

    public function getAll(): void
    {
        $this->requireAdmin();
        header('Content-Type: application/json');
        $tags = $this->service->getAll();
        echo json_encode(['success' => true, 'data' => $tags]);
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

        $id = $this->service->create(trim($data['name']));
        echo json_encode(['success' => true, 'id' => $id]);
        exit;
    }

    public function update(string $id): void
    {
        $this->requireAdmin();
        header('Content-Type: application/json');

        $data    = json_decode(file_get_contents('php://input'), true);
        $success = $this->service->update((int)$id, trim($data['name']));

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