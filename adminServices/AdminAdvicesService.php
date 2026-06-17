<?php

namespace adminServices;
use adminRepositories\AdminAdvicesRepository;

class AdminAdvicesService
{
    private AdminAdvicesRepository $repository;

    public function __construct()
    {
        $this->repository = new AdminAdvicesRepository();
    }

    public function getAllRequests(): array
    {
        return $this->repository->getAllRequests();
    }

    public function countByStatus(): array
    {
        return $this->repository->countByStatus();
    }
}