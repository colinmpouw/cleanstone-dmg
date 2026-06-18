<?php

namespace controllers;
use services\CartService;
class CartController
{

    private $cartService;

    public function __construct($router)
    {
        $this->cartService= new CartService();

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

       $cartItems = $this->cartService->getCartItems($userId);

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