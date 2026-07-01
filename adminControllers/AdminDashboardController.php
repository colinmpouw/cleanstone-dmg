<?php

namespace adminControllers;



use adminServices\AdminDashboardService;

class AdminDashboardController
{
    private $service;
    public function __construct($router)
    {
        $this->service = new AdminDashboardService();

        $router->get('/admin', [$this, 'adminURL']);
        $router->get('/admin/dashboard', [$this, 'dashboardPage']);

        // ✅ NEW API ROUTES
        $router->get('/api/admin/dashboard/stats', [$this, 'stats']);
        $router->get('/api/admin/dashboard/revenue', [$this, 'revenue']);
        $router->get('/api/admin/dashboard/categories', [$this, 'categories']);
        $router->get('/api/admin/dashboard/orders', [$this, 'orders']);
        $router->get('/api/admin/dashboard/advice', [$this, 'advice']);
    }

    public function adminURL()
    {
        $user = $_SESSION['user'] ?? null;
        if (!$user || $user['role'] !== 'admin') {
            header('Location: /admin/login');
            exit();
        }

        header('Location: /admin/dashboard');
        exit();
    }

    public function dashboardPage()
    {
        $user = $_SESSION['user'] ?? null;
        if (!$user || $user['role'] !== 'admin') {
            header('Location: /admin/login');
            exit();
        }
        require_once __DIR__ . '/../admin/adminDashboard.php';
        exit();
    }

    /* ===================================================== */
    /* ✅ STATS                                                */
    /* ===================================================== */


    public function stats()
    {
        header('Content-Type: application/json');

        echo json_encode(
            $this->service->getStats()
        );

        exit();
    }

    public function revenue()
    {
        header('Content-Type: application/json');

        echo json_encode(
            $this->service->getRevenue()
        );

        exit();
    }

    public function categories()
    {
        header('Content-Type: application/json');

        echo json_encode(
            $this->service->getCategories()
        );

        exit();
    }

    public function orders()
    {
        header('Content-Type: application/json');

        echo json_encode(
            $this->service->getRecentOrders()
        );

        exit();
    }

    public function advice()
    {
        header('Content-Type: application/json');

        echo json_encode(
            $this->service->getAdviceRequests()
        );

        exit();
    }

}