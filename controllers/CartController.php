<?php

namespace controllers;

class CartController
{


    public function __construct($router)
    {


        $router->get('/winkelwagen', [$this, 'cartPage']);
        $router->get('/api/get_all_cart_item', [$this, 'getAllCartItems']);
        $router->delete('/api/remove_from_cart/{item_id}', [$this, 'removeFromCart']);
        $router->put('/api/change_cart_quantity', [$this, 'changeQuantity']);

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


    public function getAllCartItems(): void
    {
        $userId = $_SESSION['user']['id'] ?? null;

        if ($userId === null || empty($userId)) {
            header('Location: /login');
            exit;
        }

        $cartItems = [
            [
                "id" => 1,
                "brand" => "Lithofin",
                "name" => "Lithofin MN Allesreiniger",
                "price" => 24.95,
                "quantity" => 2,
                "image" => ""
            ],
            [
                "id" => 2,
                "brand" => "Akemi",
                "name" => "Akemi Marble Protector",
                "price" => 39.95,
                "quantity" => 1,
                "image" => ""
            ]
        ];

        header('Content-Type: application/json');

        echo json_encode([
            "success" => true,
            "data" => $cartItems
        ]);
    }

    public function removeFromCart(): void
    {

    }

    public function changeQuantity(): void
    {

    }

}