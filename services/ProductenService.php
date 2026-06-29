<?php

namespace services;

use repositories\ProductenRepository;

class ProductenService
{
    private ProductenRepository $repository;

    public function __construct()
    {
        $this->repository = new ProductenRepository();
    }

    public function getAllProducts(): array
    {
        return $this->repository->getAllProducts();
    }

    public function getCategories(): array
    {
        return $this->repository->getCategories();
    }

    public function getBrands(): array
    {
        return $this->repository->getBrands();
    }

    public function getTopProducts(): array
    {
        return $this->repository->getTopProducts();
    }

    public function searchProductsForAi(string $searchTerm): array
    {
        $rows = $this->repository->searchProductsForAi($searchTerm);
        return $this->buildSimpleProducts($rows);
    }

    public function getTopProductsForAi(): array
    {
        $rows = $this->repository->getTopProductsForAi();
        return $this->buildSimpleProducts($rows);
    }

    private function buildSimpleProducts($rows)
    {
        if (empty($rows)) {
            return [];
        }

        return array_map(function ($row) {
            return [
                "id" => $row['id'],
                "name" => $row['name'],
                "price" => $row['price'],
                "avg_rating" => $row['avg_rating'] ?? null,
                "review_count" => $row['review_count'] ?? 0
            ];
        }, $rows);
    }
}
