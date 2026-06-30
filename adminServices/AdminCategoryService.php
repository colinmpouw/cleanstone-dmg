<?php

namespace adminServices;
use adminRepositories\AdminCategoryRepository;

class AdminCategoryService
{
    private AdminCategoryRepository $repository;

    public function __construct()
    {
        $this->repository = new AdminCategoryRepository();
    }

    public function getAll(): array { return $this->repository->getAll(); }
    public function create(array $d): int { return $this->repository->create($d); }
    public function update(int $id, array $d): bool { return $this->repository->update($id, $d); }
    public function delete(int $id): bool { return $this->repository->delete($id); }
}