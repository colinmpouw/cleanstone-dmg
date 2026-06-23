<?php

namespace services;
use repositories\AccountRepository;

class AccountService
{
    private AccountRepository $repository;

    public function __construct()
    {
        $this->repository = new AccountRepository();
    }

    public function getAccountData(int $user_id): array
    {
        $advies = $this->repository->getAdviesRequest($user_id);

        return [
            'order_count'   => $this->repository->getOrderCount($user_id),
            'advies'        => $advies,
            'message_count' => $this->repository->getMessageCount($user_id),
            'recent_orders' => $this->repository->getRecentOrders($user_id),
        ];
    }
}