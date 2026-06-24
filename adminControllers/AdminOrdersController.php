<?php

namespace adminControllers;

use adminServices\AdminOrdersService;
use Exception;

class AdminOrdersController
{
    private $adminOrdersService;

    public function __construct($router)
    {
        $this->adminOrdersService = new AdminOrdersService();

        $router->get('/admin/bestellingen', [$this, 'ordersPage']);
        $router->get('/api/admin/get_all_orders', [$this, 'getAllOrders']);
    }

    public function ordersPage()
    {
        require_once __DIR__ . '/../admin/adminOrders.php';
        die();
    }

    public function getAllOrders()
    {
        header('Content-Type: application/json');

        // ✅ FIXED: block if NOT logged in
        if (!$this->isAdminLoggedIn()) {
            http_response_code(401);

            echo json_encode([
                "success" => false,
                "message" => "Unauthorized"
            ]);
            exit;
        }

        try {
            $data = $this->adminOrdersService->getAllOrders();

            echo json_encode([
                "success" => true,
                "message" => "success",
                "data" => $data
            ]);
        } catch (Exception $e) {
            http_response_code(500);

            echo json_encode([
                "success" => false,
                "message" => "Something went wrong"
            ]);
        }
    }

    private function isAdminLoggedIn(): bool
    {
        return !empty($_SESSION['user']['id']) &&
            $_SESSION['user']['role'] === 'admin';
    }
}