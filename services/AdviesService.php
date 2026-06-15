<?php

namespace services;
use repositories\AdviesRepository;

class AdviesService
{
    private AdviesRepository $repository;

    public function __construct()
    {
        $this->repository = new AdviesRepository();
    }

    public function createRequest(array $data): int
    {
        return $this->repository->createRequest($data);
    }

    public function saveImage(int $request_id, string $filename): void
    {
        $this->repository->saveImage($request_id, $filename);
    }
}