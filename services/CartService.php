<?php

namespace services;
use repositories\BrandsRepository;
use repositories\CartRepository;

class CartService
{
    private $repository;

    public function __construct()
    {
        $this->repository = new CartRepository();
    }

    public function getCartItems(){
        $user_id = $_SESSION['user']['id'] ?? null;
        if ($user_id === null || empty($user_id)) {
         return null;
        }
        return $this->repository->getCartItems($user_id);
    }

}