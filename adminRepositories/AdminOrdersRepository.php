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
}