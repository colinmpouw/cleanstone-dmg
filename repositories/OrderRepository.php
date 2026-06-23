<?php

namespace repositories;

use controllers\DatabaseController;

class OrderRepository
{
    private $DB;

    public function __construct()
    {
        $this->DB = new DatabaseController();
    }


    public function createOrder($userId, $data)
    {
        $sql = "INSERT INTO `orders` (
                `user_id`,
                `total_price`,
                `status`,
                `payment_method`,
                `delivery_option`,
                `delivery_price`,
                `shipping_address_id`,
                `invoice_address_id`,
                `discount_code_id`,
                `discount_amount`,
                `has_bundle`
            ) VALUES (
                :user_id,
                :total_price,
                :status,
                :payment_method,
                :delivery_option,
                :delivery_price,
                :shipping_address_id,
                :invoice_address_id,
                :discount_code_id,
                :discount_amount,
                :has_bundle
            )";

        $params = [
            ':user_id' => $userId,
            ':total_price' => $data['total_price'],
            ':status' => $data['status'],
            ':payment_method' => $data['payment_method'],
            ':delivery_option' => $data['delivery_option'],
            ':delivery_price' => $data['delivery_price'],
            ':shipping_address_id' => $data['shipping_address_id'],
            ':invoice_address_id' => $data['invoice_address_id'] ?? null,
            ':discount_code_id' => $data['discount_code_id'] ?? null,
            ':discount_amount' => $data['discount_amount'] ?? 0,
            ':has_bundle' => $data['has_bundle'] ?? 0,
        ];

        $this->DB->save($sql, $params);

        return $this->DB->lastInsertId();
    }

    public function addOrderItem(array $order): void
    {
        $sql = "INSERT INTO order_items 
            (order_id, product_id, quantity, price)
            VALUES 
            (:order_id, :product_id, :quantity, :price)";

        $params = [
            ':order_id'   => $order['order_id'],
            ':product_id' => $order['product_id'],
            ':quantity'   => $order['quantity'],
            ':price'      => $order['price'],
        ];

        $this->DB->save($sql, $params);
    }
    public function addOrderBundle(array $order): void
    {
        $sql = "INSERT INTO order_bundles 
            (order_id, bundle_id, quantity, price)
            VALUES 
            (:order_id, :bundle_id, :quantity, :price)";

        $params = [
            ':order_id'  => $order['order_id'],
            ':bundle_id' => $order['bundle_id'],
            ':quantity'  => $order['quantity'],
            ':price'     => $order['price'],
        ];

        $this->DB->save($sql, $params);
    }


    public function updateOrderStatus($orderId, $status)
    {
        $sql = "UPDATE orders SET status = :status WHERE id = :id";
        return $this->DB->save($sql, [
            'status' => $status,
            'id' => $orderId
        ]);
    }


}