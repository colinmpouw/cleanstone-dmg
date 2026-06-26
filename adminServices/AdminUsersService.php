<?php

namespace adminServices;
use adminRepositories\AdminUsersRepository;

class AdminUsersService
{
    private AdminUsersRepository $repository;

    public function __construct()
    {
        $this->repository = new AdminUsersRepository();
    }

    public function getAllUsers(): array
    {
        return $this->repository->getAllUsers();
    }
}