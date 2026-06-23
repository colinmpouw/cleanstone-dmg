<?php

namespace adminRepositories;

use adminControllers\AdminDatabaseController;

class AdminUsersRepository
{
    private $DB;

    public function __construct()
    {
        $this->DB = new AdminDatabaseController();
    }
}