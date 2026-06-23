<?php

namespace adminServices;

use adminRepositories\AdminProductsRepository;

class AdminProductsService
{
    private $repository;
    public function __construct()
    {
        $this->repository = new AdminProductsRepository();
    }

}