<?php

namespace adminServices;

use adminRepositories\AdminUsersRepository;

class AdminUsersService
{
    private $repository;
    public function __construct()
    {
        $this->repository = new AdminUsersRepository();
    }

}