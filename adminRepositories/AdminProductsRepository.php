<?php

namespace adminRepositories;

use adminControllers\AdminDatabaseController;

class AdminProductsRepository
{
    private $DB;

    public function __construct()
    {
        $this->DB = new AdminDatabaseController();
    }
}