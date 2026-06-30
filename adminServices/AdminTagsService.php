<?php

namespace adminServices;
use adminRepositories\AdminTagsRepository;

class AdminTagsService
{
    private AdminTagsRepository $repository;

    public function __construct()
    {
        $this->repository = new AdminTagsRepository();
    }

    public function getAll(): array { return $this->repository->getAll(); }
    public function create(string $name): int { return $this->repository->create($name); }
    public function update(int $id, string $name): bool { return $this->repository->update($id, $name); }
    public function delete(int $id): bool { return $this->repository->delete($id); }
}