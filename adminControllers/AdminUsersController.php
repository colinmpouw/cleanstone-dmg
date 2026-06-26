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
}