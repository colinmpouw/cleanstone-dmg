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
}
