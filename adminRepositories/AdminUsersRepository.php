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

    public function getUserById(int $id): ?array
    {
        $user = $this->DB->read(
            "SELECT u.id, u.username, u.email, u.phone, u.role, u.created_at,
                COUNT(DISTINCT o.id) as order_count,
                COUNT(DISTINCT ar.id) as advies_count,
                COUNT(DISTINCT r.id) as review_count
         FROM users u
         LEFT JOIN orders o ON o.user_id = u.id
         LEFT JOIN advice_requests ar ON ar.user_id = u.id
         LEFT JOIN reviews r ON r.user_id = u.id
         WHERE u.id = :id
         GROUP BY u.id",
            ['id' => $id]
        );

        if (empty($user)) return null;
        $user = $user[0];

        $user['reviews'] = $this->DB->read(
            "SELECT r.id, r.rating, r.review, r.created_at, p.name as product_name
         FROM reviews r
         LEFT JOIN products p ON p.id = r.product_id
         WHERE r.user_id = :user_id
         ORDER BY r.created_at DESC",
            ['user_id' => $id]
        ) ?: [];

        return $user;
    }

    public function updateUser(int $id, array $data): bool
    {
        return $this->DB->save(
            "UPDATE users SET username = :username, email = :email, phone = :phone, role = :role WHERE id = :id",
            [
                'username' => $data['name'],
                'email'    => $data['email'],
                'phone'    => $data['phone'],
                'role'     => $data['role'] === 'admin' ? 'admin' : 'customer',
                'id'       => $id
            ]
        );
    }

    public function deleteReview(int $id): bool
    {
        return $this->DB->save(
            "DELETE FROM reviews WHERE id = :id",
            ['id' => $id]
        );
    }
}