<?php

namespace controllers;

use services\CartService;

class CartController
{

    private $cartService;

    public function __construct($router)
    {
        $this->cartService = new CartService();

        $router->get('/winkelwagen', [$this, 'cartPage']);
        $router->post('/api/add_cart_item', [$this, 'addCartItem']);
        $router->get('/api/get_all_cart_item', [$this, 'getAllCartItems']);
        $router->delete('/api/remove_from_cart', [$this, 'removeFromCart']);
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

    public function addCartItem(): void
    {
        $userId = $_SESSION['user']['id'] ?? null;
        if ($userId === null || empty($userId)) {
            header('Location: /login');
            exit;
        }

        $data = json_decode(file_get_contents("php://input"), true);
        $productId = $data['product_id'] ?? null;
        $quantity = $data['quantity'] ?? 1;

        if ($productId === null || $quantity === null) {
            echo json_encode([
                "success" => false,
                "message" => "Product ID and quantity are required."
            ]);
            return;
        }

        $result = $this->cartService->addCartItem($userId, $productId, $quantity);

        if ($result) {
            echo json_encode([
                "success" => true,
                "message" => "Item added to cart successfully."
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Failed to add item to cart."
            ]);
        }
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
        $user_id = $_SESSION['user']['id'] ?? null;
        if ($user_id === null || empty($user_id)) {
            header('Location: /login');
            exit;
        }

        $data = json_decode(file_get_contents("php://input"), true);
        $productId = $data['product_id'] ?? null;
        $bundleId = $data['bundle_id'] ?? null;

        $result = $this->cartService->removeFromCart($user_id, $productId, $bundleId);
        if ($result == null) {
            echo json_encode([
                "success" => false,
                "message" => "Failed to remove item from cart."
            ]);
            return;
        }
        echo json_encode([
            "success" => true,
            "data" => "Item successfully removed from cart."
        ]);
    }

    public function changeQuantity(): void
    {
        $userId = $_SESSION['user']['id'] ?? null;
        if ($userId === null || empty($userId)) {
            header('Location: /login');
            exit;
        }

        $data = json_decode(file_get_contents("php://input"), true);

        $itemId = $data['cart_item_id'] ?? null;
        $bundle_id = $data['bundle_id'] ?? null;
        $quantity = $data['quantity'] ?? 1;


        if ($itemId === null || $quantity === null) {
            echo json_encode([
                "success" => false,
                "message" => "Item ID and quantity are required."
            ]);
            return;
        }

        $result = $this->cartService->changeQuantity($userId, $quantity, $itemId, $bundle_id);

        if ($result) {
            echo json_encode([
                "success" => true,
                "message" => "Quantity updated successfully."
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Failed to update quantity.",
                "errors" => $data
            ]);
        }
    }

}