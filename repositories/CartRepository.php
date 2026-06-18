<?php

namespace repositories;

use controllers\DatabaseController;

class CartRepository
{
    private $DB;

    public function __construct()
    {
        $this->DB = new DatabaseController();
    }

    public function addCartItem($user_id, $product_id, $quantity)
    {
        $sql = "INSERT INTO cart_items (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)";
        $params = [':user_id' => $user_id, ':product_id' => $product_id, ':quantity' => $quantity];
        return $this->DB->save($sql, $params);
    }

    public function getCartItems($user_id)
    {
        $sql = "
SELECT *
FROM cart_products_details
WHERE user_id = :user_id;

";
        $params = [':user_id' => $user_id];
        return $this->DB->read($sql, $params);
    }

    public function removeFromCart($user_id, $item_id)
    {
        $sql = "DELETE FROM cart_items"
            . " WHERE user_id = :user_id AND product_id = :item_id";
        $params = [':user_id' => $user_id, ':item_id' => $item_id];
        return $this->DB->save($sql, $params);
    }
    public function changeQuantity($user_id, $item_id, $quantity){
        $sql = "UPDATE cart_items"
            . " SET quantity = :quantity"
            . " WHERE user_id = :user_id AND product_id = :item_id";
        $params = [':user_id' => $user_id, ':item_id' => $item_id, ':quantity' => $quantity];
        return $this->DB->save($sql, $params);
    }
}