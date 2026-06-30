<?php

namespace adminServices;

use adminRepositories\AdminDashboardRepository;

class AdminDashboardService
{
    private AdminDashboardRepository $repository;

    public function __construct()
    {
        $this->repository = new AdminDashboardRepository();
    }

    public function getStats(): array
    {
        return [
            'revenue' => $this->repository->getRevenueStats(),
            'orders' => $this->repository->getOrderStats(),
            'active_products' => $this->repository->getProductStats(),
            'advice_requests' => $this->repository->getAdviceStats()
        ];
    }

    public function getRevenue(): array
    {
        return [
            'total' => $this->repository->getRevenueTotal(),
            'points' => $this->repository->getRevenueChart()
        ];
    }

    public function getCategories(): array
    {
        return $this->repository->getCategoryDistribution();
    }

    public function getRecentOrders(): array
    {
        return $this->repository->getRecentOrders();
    }

    public function getAdviceRequests(): array
    {
        return $this->repository->getRecentAdvice();
    }
}