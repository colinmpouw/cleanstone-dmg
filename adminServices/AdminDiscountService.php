<?php

namespace adminServices;
use adminRepositories\AdminDiscountRepository;

class AdminDiscountService
{
    private AdminDiscountRepository $repository;

    public function __construct()
    {
        $this->repository = new AdminDiscountRepository();
    }

    public function getAll(): array
    {
        return $this->repository->getAll();
    }

    public function create(array $data): int
    {
        return $this->repository->create($data);
    }

    public function update(int $id, array $data): bool
    {
        return $this->repository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }

    public function toggleStatus(int $id, string $status): bool
    {
        return $this->repository->toggleStatus($id, $status);
    }
}