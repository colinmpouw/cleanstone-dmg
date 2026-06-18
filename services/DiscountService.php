<?php

namespace services;

use repositories\DiscountRepository;

class DiscountService
{
    private $repository;

    public function __construct()
    {
        $this->repository = new DiscountRepository();
    }

    public function check_discount($discount)
    {
        $result = $this->repository->check_discount($discount);
        return $result;
    }
    public function check_user_used_discount($user_id, $discount_id)
    {
        return $this->repository->check_user_used_discount($user_id, $discount_id);
    }

}