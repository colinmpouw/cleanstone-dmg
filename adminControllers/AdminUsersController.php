<?php

namespace adminControllers;
use adminServices\AdminUsersService;

class AdminUsersController
{
    private AdminUsersService $service;

    public function __construct($router)
    {
        $this->service = new AdminUsersService();

        $router->get('/admin/gebruikers', [$this, 'page']);
        $router->get('/api/admin/gebruikers', [$this, 'getAll']);
        $router->get('/admin/gebruikers/{id}', [$this, 'detailPage']);
        $router->get('/api/admin/gebruikers/{id}', [$this, 'getOne']);
        $router->put('/api/admin/gebruikers/{id}', [$this, 'update']);
        $router->delete('/api/admin/reviews/{id}', [$this, 'deleteReview']);
    }

    private function requireAdmin(): void
    {
        if (empty($_SESSION['user']['id']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: /admin/login');
            exit;
        }
    }

    public function page(): void
    {
        $this->requireAdmin();
        require_once __DIR__ . '/../admin/adminUsers.php';
    }

    public function getAll(): void
    {
        $this->requireAdmin();
        header('Content-Type: application/json');

        $users = $this->service->getAllUsers();

        echo json_encode([
            'success' => true,
            'users'   => $users
        ]);
        exit;
    }

    public function detailPage(string $id): void
    {
        $this->requireAdmin();
        require_once __DIR__ . '/../admin/adminUserDetial.php';
    }

    public function getOne(string $id): void
    {
        $this->requireAdmin();
        header('Content-Type: application/json');

        $user = $this->service->getUserById((int)$id);

        if (!$user) {
            http_response_code(404);
            echo json_encode(['error' => 'Niet gevonden']);
            return;
        }

        echo json_encode($user);
        exit;
    }

    public function update(string $id): void
    {
        $this->requireAdmin();
        header('Content-Type: application/json');

        $data    = json_decode(file_get_contents('php://input'), true);
        $success = $this->service->updateUser((int)$id, $data);

        http_response_code($success ? 200 : 500);
        echo json_encode(['success' => $success]);
        exit;
    }

    public function deleteReview(string $id): void
    {
        $this->requireAdmin();
        header('Content-Type: application/json');

        $success = $this->service->deleteReview((int)$id);

        http_response_code($success ? 200 : 500);
        echo json_encode(['success' => $success]);
        exit;
    }
}