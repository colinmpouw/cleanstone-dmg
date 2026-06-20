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

    public function removeFromCart($user_id, $item_id, $bundle_id)
    {
        $sql = "DELETE FROM cart_items"
            . " WHERE user_id = :user_id AND product_id = :item_id OR bundle_id = :bundle_id;";
        $params = [':user_id' => $user_id, ':item_id' => $item_id, ':bundle_id' => $bundle_id];
        return $this->DB->save($sql, $params);
    }

    public function changeQuantity($user_id, $quantity, $item_id = null, $bundle_id = null)
    {
        $sql = "UPDATE cart_items 
            SET quantity = :quantity
            WHERE user_id = :user_id
            AND (
                (:item_id IS NOT NULL AND id = :item_id)
                OR
                (:bundle_id IS NOT NULL AND bundle_id = :bundle_id)
            )";

        $params = [
            ':user_id'   => $user_id,
            ':item_id'   => $item_id,
            ':bundle_id' => $bundle_id,
            ':quantity'  => $quantity
        ];

        return $this->DB->save($sql, $params);
    }

    public function clearCart($user_id){
        $sql = "DELETE FROM cart_items WHERE user_id = :user_id;";
        $params = [':user_id' => $user_id];
        return $this->DB->save($sql, $params);
    }
}