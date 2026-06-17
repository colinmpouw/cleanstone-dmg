<?php

namespace controllers;

class CartController
{


    public function __construct($router)
    {


        $router->get('/winkelwagen', [$this, 'cartPage']);

    }

    public function cartPage(): void
    {
        $userId = $_SESSION['user']['id'] ?? null;
        if ($userId === null || empty($userId)) {
            header('Location: /login');
            exit;
        }
        require __DIR__ . '/../public/cart.php';
    }




}