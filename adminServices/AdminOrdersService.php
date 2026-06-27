<?php

namespace adminServices;

use adminRepositories\AdminOrdersRepository;

class AdminOrdersService
{
    private $repository;

    public function __construct()
    {
        $this->repository = new AdminOrdersRepository();
    }

    public function getAllOrders()
    {
        $rows = $this->repository->getAllOrders();
        $data = $this->buildOrders($rows);
        return $data;
    }
    public function changeStatus($input)
    {
        if (empty($input)) {
            return false;
        }

        return $this->repository->changeStatus($input);
    }

    private function buildOrders($rows)
    {
        if (empty($rows)) {
            return [];
        }

        $orders = [];
        $seenProducts = [];
        $seenBundles = [];

        foreach ($rows as $row) {

            $orderId = $row['order_id'];


            if (!isset($orders[$orderId])) {
                $orders[$orderId] = [

                    "order_id" => $orderId,
                    "total_price" => $row['total_price'],
                    "status" => $row['status'],
                    "payment_method" => $row['payment_method'],
                    "delivery_option" => $row['delivery_option'],
                    "delivery_price" => $row['delivery_price'],
                    "created_at" => $row['created_at'],

                    "user_id" => $row['user_id'],
                    "username" => $row['username'],
                    "email" => $row['email'],

                    // ✅ shipping
                    "shipping_first_name" => $row['shipping_first_name'],
                    "shipping_last_name" => $row['shipping_last_name'],
                    "shipping_street" => $row['shipping_street'],
                    "shipping_house_number" => $row['shipping_house_number'],
                    "shipping_city" => $row['shipping_city'],
                    "shipping_postal_code" => $row['shipping_postal_code'],
                    "shipping_country" => $row['shipping_country'],

                    // ✅ invoice
                    "invoice_first_name" => $row['invoice_first_name'],
                    "invoice_last_name" => $row['invoice_last_name'],
                    "invoice_street" => $row['invoice_street'],
                    "invoice_house_number" => $row['invoice_house_number'],
                    "invoice_city" => $row['invoice_city'],
                    "invoice_postal_code" => $row['invoice_postal_code'],
                    "invoice_country" => $row['invoice_country'],

                    "products" => [],
                    "bundles" => []
                ];


                $seenProducts[$orderId] = [];
                $seenBundles[$orderId] = [];
            }

            /* ✅ PRODUCTS */
            if (!empty($row['product_id'])) {
                $productId = $row['product_id'];

                if (!isset($seenProducts[$orderId][$productId])) {
                    $orders[$orderId]['products'][$productId] = [
                        "order_item_id" => $row['order_item_id'],
                        "product_id" => $productId,
                        "name" => $row['product_name'],
                        "quantity" => $row['product_quantity'],
                        "price" => $row['product_price']
                    ];

                    $seenProducts[$orderId][$productId] = true;
                }
            }

            /* ✅ BUNDLES */
            if (!empty($row['bundle_id'])) {
                $bundleId = $row['bundle_id'];

                if (!isset($seenBundles[$orderId][$bundleId])) {
                    $orders[$orderId]['bundles'][$bundleId] = [
                        "order_bundle_id" => $row['order_bundle_id'],
                        "bundle_id" => $bundleId,
                        "name" => $row['bundle_name'],
                        "quantity" => $row['bundle_quantity'],
                        "price" => $row['bundle_price']
                    ];

                    $seenBundles[$orderId][$bundleId] = true;
                }
            }
        }

        // ✅ 转成 indexed array
        foreach ($orders as &$order) {
            $order['products'] = array_values($order['products']);
            $order['bundles'] = array_values($order['bundles']);
        }

        return array_values($orders);
    }
}