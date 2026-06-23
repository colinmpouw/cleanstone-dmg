<?php

namespace repositories;
use controllers\DatabaseController;

class AccountRepository
{
    private DatabaseController $DB;

    public function __construct()
    {
        $this->DB = new DatabaseController();
    }

    public function getOrderCount(int $user_id): int
    {
        $rows = $this->DB->read(
            "SELECT COUNT(*) as count FROM orders WHERE user_id = :user_id",
            ['user_id' => $user_id]
        );
        return (int)($rows[0]['count'] ?? 0);
    }

    public function getAdviesRequest(int $user_id): ?array
    {
        $rows = $this->DB->read(
            "SELECT * FROM advice_requests WHERE user_id = :user_id ORDER BY created_at DESC LIMIT 1",
            ['user_id' => $user_id]
        );
        return $rows[0] ?? null;
    }

    public function getMessageCount(int $user_id): int
    {
        $rows = $this->DB->read(
            "SELECT COUNT(*) as count FROM advice_messages am
             JOIN advice_requests ar ON am.request_id = ar.id
             WHERE ar.user_id = :user_id",
            ['user_id' => $user_id]
        );
        return (int)($rows[0]['count'] ?? 0);
    }

    public function getRecentOrders(int $user_id, int $limit = 3): array
    {
        return $this->DB->read(
            "SELECT o.id, o.total_price, o.status, o.created_at
             FROM orders o
             WHERE o.user_id = :user_id
             ORDER BY o.created_at DESC
             LIMIT " . (int)$limit,
            ['user_id' => $user_id]
        ) ?: [];
    }
}