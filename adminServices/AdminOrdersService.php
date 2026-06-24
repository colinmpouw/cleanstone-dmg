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

}