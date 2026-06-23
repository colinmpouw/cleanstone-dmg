<?php

namespace adminRepositories;

use adminControllers\AdminDatabaseController;

class AdminDashboardRepository
{
    private $DB;

    public function __construct()
    {
        $this->DB = new AdminDatabaseController();
    }
}