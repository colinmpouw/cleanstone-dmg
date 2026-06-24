<?php

namespace services;
use repositories\ReviewsRepository;

class ReviewsService
{
    private ReviewsRepository $repository;

    public function __construct()
    {
        $this->repository = new ReviewsRepository();
    }

    public function getByUser(int $user_id): array
    {
        return $this->repository->getByUser($user_id);
    }

    public function update(int $id, int $user_id, int $rating, string $review): bool
    {
        return $this->repository->update($id, $user_id, $rating, $review);
    }

    public function delete(int $id, int $user_id): bool
    {
        return $this->repository->delete($id, $user_id);
    }
}