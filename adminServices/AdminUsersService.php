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

    public function getUserById(int $id): ?array
    {
        return $this->repository->getUserById($id);
    }

    public function updateUser(int $id, array $data): bool
    {
        return $this->repository->updateUser($id, $data);
    }

    public function deleteReview(int $id): bool
    {
        return $this->repository->deleteReview($id);
    }
}