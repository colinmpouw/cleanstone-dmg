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

    public function addCartItem($user_id, $product_id, $quantity)
    {
        if ($user_id === null || empty($user_id)) {
            return null;
        }
        return $this->repository->addCartItem($user_id, $product_id, $quantity);
    }

    public function getCartItems($user_id){

        if ($user_id === null || empty($user_id)) {
         return null;
        }
        return $this->repository->getCartItems($user_id);
    }

    public function removeFromCart($user_id, $item_id, $bundle_id){
        if ($user_id === null || empty($user_id)) {
            return null;
        }
        return $this->repository->removeFromCart($user_id, $item_id, $bundle_id);
    }
    public function changeQuantity($user_id, $item_id, $quantity)
    {
        if ($user_id === null || empty($user_id)) {
            return null;
        }
        return $this->repository->changeQuantity($user_id, $item_id, $quantity);
    }
}