<?php

namespace controllers;


use services\OrderService;

class OrderController
{

    private $orderService;

    public function __construct($router)
    {
        $this->orderService = new OrderService();

        $router->get('/bestelling', [$this, 'orderPage']);
        $router->post('/api/place_order', [$this, 'placeOrder']);

    }

    public function orderPage(): void
    {
        $userId = $_SESSION['user']['id'] ?? null;
        if ($userId === null || empty($userId)) {
            header('Location: /login');
            exit;
        }

        require __DIR__ . '/../public/order.php';
    }

    public function placeOrder(): void
    {
        $userId = $_SESSION['user']['id'] ?? null;
        if ($userId === null || empty($userId)) {
            header('Location: /login');
            exit;
        }

        $data = json_decode(file_get_contents("php://input"), true);

        try {
            $orderId = $this->orderService->placeOrder($userId, $data);
            echo json_encode([
                "success" => true,
                "data" => ["order_id" => $orderId]
            ]);
        } catch (Exception $e) {
            echo json_encode([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        }
    }


}