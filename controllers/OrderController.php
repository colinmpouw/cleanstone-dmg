<?php

namespace controllers;

use services\CartService;

class OrderController
{

    private $cartService;

    public function __construct($router)
    {
        $this->cartService = new CartService();

        $router->get('/bestelling', [$this, 'orderPage']);


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



}