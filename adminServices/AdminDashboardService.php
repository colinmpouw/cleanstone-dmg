<?php

namespace adminServices;

use adminRepositories\AdminDashboardRepository;

class AdminDashboardService
{
    private $repository;
    public function __construct()
    {
        $this->repository = new AdminDashboardRepository();
    }

}