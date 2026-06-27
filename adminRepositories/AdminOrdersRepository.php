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
}