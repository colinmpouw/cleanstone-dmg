<?php

namespace services;
use repositories\BrandsRepository;

class BrandsService
{
    private $repository;

    public function __construct()
    {
        $this->repository = new BrandsRepository();
    }

    public function get_all_brands()
    {
        return $this->repository->get_all_brands();
    }
}