<?php

namespace services;
use repositories\BundelsRepository;
class BundelsService
{
    private $repository;

    public function __construct()
    {
        $this->repository = new BundelsRepository();
    }

    public function get_all_bundels()
    {
        return $this->repository->get_all_bundels();
    }
}
