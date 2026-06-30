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

    public function getOrdersByUser(int $user_id): array
    {
        $orders = $this->DB->read(
            "SELECT o.id, o.total_price, o.status, o.payment_method,
                o.delivery_option, o.created_at,
                (SELECT COUNT(*) FROM order_items oi WHERE oi.order_id = o.id) +
                (SELECT COUNT(*) FROM order_bundles ob WHERE ob.order_id = o.id) as product_count
         FROM orders o
         WHERE o.user_id = :user_id
         ORDER BY o.created_at DESC",
            ['user_id' => $user_id]
        ) ?: [];

        foreach ($orders as &$order) {
            $products = $this->DB->read(
                "SELECT p.name, p.image, p.sku, oi.quantity, oi.price
             FROM order_items oi
             LEFT JOIN products p ON p.id = oi.product_id
             WHERE oi.order_id = :order_id",
                ['order_id' => $order['id']]
            ) ?: [];

            $bundles = $this->DB->read(
                "SELECT b.name, b.image, 'BUNDEL' as sku, ob.quantity, ob.price
             FROM order_bundles ob
             LEFT JOIN bundles b ON b.id = ob.bundle_id
             WHERE ob.order_id = :order_id",
                ['order_id' => $order['id']]
            ) ?: [];

            $order['products'] = array_merge($products, $bundles);
        }

        return $orders;
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

    public function getOrderForInvoice(int $order_id, int $user_id): ?array
    {
        $order = $this->DB->read(
            "SELECT o.*,
                a.first_name, a.last_name, a.street, a.house_number,
                a.postal_code, a.city, a.country
         FROM orders o
         LEFT JOIN addresses a ON a.id = o.shipping_address_id
         WHERE o.id = :order_id AND o.user_id = :user_id",
            ['order_id' => $order_id, 'user_id' => $user_id]
        );

        if (empty($order)) return null;
        $order = $order[0];

        // producten
        $products = $this->DB->read(
            "SELECT p.name, p.sku, oi.quantity, oi.price
         FROM order_items oi
         LEFT JOIN products p ON p.id = oi.product_id
         WHERE oi.order_id = :order_id",
            ['order_id' => $order_id]
        ) ?: [];

        // bundels
        $bundles = $this->DB->read(
            "SELECT b.name, 'BUNDEL' as sku, ob.quantity, ob.price
         FROM order_bundles ob
         LEFT JOIN bundles b ON b.id = ob.bundle_id
         WHERE ob.order_id = :order_id",
            ['order_id' => $order_id]
        ) ?: [];

        $order['products'] = array_merge($products, $bundles);

        return $order;
    }

    public function getOrderById(int $order_id, int $user_id): ?array
    {
        $order = $this->DB->read(
            "SELECT o.id, o.total_price, o.status, o.payment_method,
                o.delivery_option, o.delivery_price, o.discount_amount,
                o.created_at,
                CONCAT(a.street, ' ', a.house_number, ', ', a.postal_code, ' ', a.city) as address
         FROM orders o
         LEFT JOIN addresses a ON a.id = o.shipping_address_id
         WHERE o.id = :order_id AND o.user_id = :user_id",
            ['order_id' => $order_id, 'user_id' => $user_id]
        );

        if (empty($order)) return null;
        $order = $order[0];

        // producten
        $products = $this->DB->read(
            "SELECT p.name, p.image, p.sku, oi.quantity, oi.price
         FROM order_items oi
         LEFT JOIN products p ON p.id = oi.product_id
         WHERE oi.order_id = :order_id",
            ['order_id' => $order_id]
        ) ?: [];

        // bundels
        $bundles = $this->DB->read(
            "SELECT b.name, b.image, ob.quantity, ob.price, 'BUNDEL' as sku
         FROM order_bundles ob
         LEFT JOIN bundles b ON b.id = ob.bundle_id
         WHERE ob.order_id = :order_id",
            ['order_id' => $order_id]
        ) ?: [];

        $order['products'] = array_merge($products, $bundles);

        $order['subtotal'] = array_sum(array_map(
            fn($p) => $p['price'] * $p['quantity'],
            $order['products']
        ));

        $order['shipping'] = $order['delivery_price'] ?? 0;
        $order['total']    = $order['total_price'];

        // status mappen naar timeline keys
        $statusMap = [
            'pending'    => 'geplaatst',
            'paid'       => 'betaald',
            'processing' => 'verwerking',
            'shipped'    => 'verzonden',
            'completed'  => 'bezorgd',
            'cancelled'  => 'geannuleerd',
        ];
        $order['status'] = $statusMap[$order['status']] ?? $order['status'];

        return $order;
    }


    public function updateOrderStatus($orderId, $status)
    {
        $sql = "UPDATE orders SET status = :status WHERE id = :id";
        return $this->DB->save($sql, [
            'status' => $status,
            'id' => $orderId
        ]);
    }

    public function getOrderForMail(int $orderId): ?array
    {
        $order = $this->DB->read(
            "SELECT
            o.*,
            u.email,
            a.first_name,
            a.last_name,
            a.street,
            a.house_number,
            a.postal_code,
            a.city,
            a.country
        FROM orders o
        JOIN users u ON u.id = o.user_id
        LEFT JOIN addresses a ON a.id = o.shipping_address_id
        WHERE o.id = :order_id",
            ['order_id' => $orderId]
        );

        if (empty($order)) {
            return null;
        }

        $order = $order[0];

        $products = $this->DB->read(
            "SELECT
            p.name,
            oi.quantity,
            oi.price
        FROM order_items oi
        LEFT JOIN products p ON p.id = oi.product_id
        WHERE oi.order_id = :order_id",
            ['order_id' => $orderId]
        ) ?: [];

        $bundles = $this->DB->read(
            "SELECT
            b.name,
            ob.quantity,
            ob.price
        FROM order_bundles ob
        LEFT JOIN bundles b ON b.id = ob.bundle_id
        WHERE ob.order_id = :order_id",
            ['order_id' => $orderId]
        ) ?: [];

        $order['products'] = array_merge($products, $bundles);

        return $order;
    }


}