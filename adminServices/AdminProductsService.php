<?php

namespace adminServices;

use adminRepositories\AdminProductsRepository;

class AdminProductsService
{
    private $repository;
    public function __construct()
    {
        $this->repository = new AdminProductsRepository();
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
    public function getTags(): array
    {
        return $this->repository->getTags();
    }

    public function getProductById($id){
        return $this->repository->getProductById($id);
    }

}