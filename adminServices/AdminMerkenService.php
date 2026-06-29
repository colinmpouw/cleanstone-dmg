<?php

namespace adminServices;
use adminRepositories\AdminMerkenRepository;

class AdminMerkenService
{
    private AdminMerkenRepository $repository;

    public function __construct()
    {
        $this->repository = new AdminMerkenRepository();
    }

    public function getAll(): array        { return $this->repository->getAll(); }
    public function create(array $d): int  { return $this->repository->create($d); }
    public function update(int $id, array $d): bool { return $this->repository->update($id, $d); }
    public function delete(int $id): bool  { return $this->repository->delete($id); }
}