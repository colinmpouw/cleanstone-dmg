<?php

namespace adminControllers;
use adminServices\AdminAdvicesService;

class AdminAdvicesController
{
    private AdminAdvicesService $service;

    public function __construct($router)
    {
        $this->service = new AdminAdvicesService();

        $router->get('/admin/adviesaanvragen', [$this, 'advicePage']);
        $router->get('/admin/advieschat/{id}', [$this, 'adviceChatPage']);
        $router->get('/api/admin/adviesaanvragen', [$this, 'getAll']);
    }
    private function requireAdmin(): void
    {
        if (empty($_SESSION['user']['id']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: /admin/login');
            exit;
        }
    }
    public function advicePage(): void
    {
        $this->requireAdmin();
        require_once __DIR__ . '/../admin/adminAdvice.php';
    }

    public function adviceChatPage(int $id): void
    {
        $this->requireAdmin();
        echo '<script>window.advies_id = ' . json_encode($id) . ';</script>';
        require_once __DIR__ . '/../admin/adminAdviceChat.php';
    }

    public function getAll(): void
    {
        header('Content-Type: application/json');

        $requests = $this->service->getAllRequests();
        $counts   = $this->service->countByStatus();
        $total    = array_sum($counts);

        echo json_encode([
            'success'  => true,
            'data'     => $requests,
            'counts'   => $counts,
            'total'    => $total
        ]);
        exit;
    }
}