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
        $router->get('/bedankt', [$this, 'thankYouPage']);
        $router->post('/api/place_order', [$this, 'placeOrder']);
        $router->get('/account/bestellingen', [$this, 'pageBestellingen']);
        $router->get('/bestellingen', [$this, 'pageBestellingen']);
        $router->get('/api/account/bestellingen', [$this, 'getBestellingen']);
        $router->get('/account/bestellingen/{id}', [$this, 'pageViewBestelling']);
        $router->get('/api/account/bestellingen/{id}', [$this, 'getBestellingById']);
        $router->get('/account/bestellingen/{id}/factuur', [$this, 'factuur']);

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


    public function pageViewBestelling($id): void
    {
        $this->requireLogin();
        require __DIR__ . '/../public/account-view-bestellingen.php';
    }

    public function getBestellingById(int $id): void
    {
        $this->requireLogin();
        header('Content-Type: application/json');

        $order = $this->orderService->getOrderById($id, $_SESSION['user']['id']);

        if (!$order) {
            http_response_code(404);
            echo json_encode(['error' => 'Niet gevonden']);
            return;
        }

        echo json_encode($order);
        exit;
    }

    private function requireLogin(): void
    {
        if (empty($_SESSION['user']['id'])) {
            header('Location: /login');
            exit;
        }
    }

    public function pageBestellingen(): void
    {
        $this->requireLogin();
        require __DIR__ . '/../public/account-bestellingen.php';
    }

    public function getBestellingen(): void
    {
        $this->requireLogin();
        header('Content-Type: application/json');

        $orders = $this->orderService->getOrdersByUser($_SESSION['user']['id']);

        echo json_encode([
            'success' => true,
            'orders'  => $orders
        ]);
        exit;
    }


    public function thankYouPage(): void
    {
        $userId = $_SESSION['user']['id'] ?? null;
        if ($userId === null || empty($userId)) {
            header('Location: /login');
            exit;
        }

        require __DIR__ . '/../public/thankyou.php';
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

    public function factuur(int $id): void
    {
        $this->requireLogin();

        $order = $this->orderService->getOrderForInvoice($id, $_SESSION['user']['id']);

        if (!$order) {
            http_response_code(404);
            echo 'Bestelling niet gevonden.';
            return;
        }

        require __DIR__ . '/../public/factuur.php';
    }


}