<?php

namespace adminRepositories;
use adminControllers\AdminDatabaseController;

class AdminUsersRepository
{
    private AdminDatabaseController $DB;

    public function __construct()
    {
        $this->DB = new AdminDatabaseController();
    }

    public function getAllUsers(): array
    {
        return $this->DB->read(
            "SELECT u.id, u.username, u.email, u.phone, u.role, u.created_at,
                    COUNT(o.id) as order_count
             FROM users u
             LEFT JOIN orders o ON o.user_id = u.id
             GROUP BY u.id
             ORDER BY u.created_at DESC"
        ) ?: [];
    }
}