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
}