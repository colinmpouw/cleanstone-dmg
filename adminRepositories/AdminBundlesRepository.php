<?php

namespace adminRepositories;

use adminControllers\AdminDatabaseController;

class AdminBundlesRepository
{
    private $DB;

    public function __construct()
    {
        $this->DB = new AdminDatabaseController();
    }
}