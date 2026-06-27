<?php

namespace adminRepositories;

use adminControllers\AdminDatabaseController;

class AdminOrdersRepository
{
    private $DB;

    public function __construct()
    {
        $this->DB = new AdminDatabaseController();
    }

    public function getAllOrders()
    {
        $sql = "SELECT * FROM order_details_view";
        return $this->DB->read($sql);
    }

    public function changeStatus($input)
    {
        $sql = "UPDATE orders SET status = :status WHERE id = :id";

        return $this->DB->save($sql, [
            ':status' => $input['status'],
            ':id' => $input['order_id']
        ]);
    }

    public function getOrderForInvoice(int $order_id, int $user_id): ?array
    {
        $sql = "SELECT * FROM order_details_view WHERE order_id = :id AND user_id = :user_id";
        $order = $this->DB->read($sql, [':id' => $order_id, ':user_id' => $user_id]);
        return $order;
    }
}