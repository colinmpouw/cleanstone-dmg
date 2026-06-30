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
        $router->post('/api/admin/orders/change_status', [$this, 'changeStatus']);
        $router->get('/admin/bestellingen/{user_id}/factuur/{id}', [$this, 'factuur']);
    }

    public function ordersPage()
    {
        if (!$this->isAdminLoggedIn()) {
            header('Location: /admin/login');
            exit;
        }
        require_once __DIR__ . '/../admin/adminOrders.php';
        die();
    }

    public function getAllOrders()
    {
        header('Content-Type: application/json');

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

    public function changeStatus()
    {
        header('Content-Type: application/json');
        if (!$this->isAdminLoggedIn()) {
            http_response_code(401);

            echo json_encode([
                "success" => false,
                "message" => "Unauthorized"
            ]);
            exit;
        }
        $input = json_decode(file_get_contents("php://input"), true);
        try {
            $data = $this->adminOrdersService->changeStatus($input);
            echo json_encode([
                "success" => $data,
                "message" => $data ? "Status updated successfully" : "Status update failed",
            ]);
        } catch (Exception $e) {
            http_response_code(500);

            echo json_encode([
                "success" => false,
                "message" => "Something went wrong"
            ]);
        }
    }

    public function factuur($user_id, $id): void
    {

        $user_id = (int) $user_id;
        $id = (int) $id;

        if (!$this->isAdminLoggedIn()) {
            http_response_code(401);

            echo json_encode([
                "success" => false,
                "message" => "Unauthorized"
            ]);
            exit;
        }

        $order = $this->adminOrdersService->getOrderForInvoice($id, $user_id);

        if (!$order) {
            http_response_code(404);
            echo 'Bestelling niet gevonden.';
            return;
        }
        require_once __DIR__ . '/../admin/adminFactuur.php';
    }

    private function isAdminLoggedIn(): bool
    {
        return !empty($_SESSION['user']['id']) &&
            $_SESSION['user']['role'] === 'admin';
    }
}