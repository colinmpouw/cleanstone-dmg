<?php

namespace repositories;

use controllers\DatabaseController;

class UserRepository
{
    private DatabaseController $DB;

    public function __construct()
    {
        $this->DB = new DatabaseController();
    }

    public function findByEmail(string $email): ?array
    {
        $result = $this->DB->read(
            'SELECT * FROM users WHERE email = ? LIMIT 1',
            [$email]
        );

        return $result[0] ?? null;
    }

    public function updatePassword(int $id, string $hash): bool
    {
        return $this->DB->save(
            "UPDATE users SET password_hash = :hash WHERE id = :id",
            ['hash' => $hash, 'id' => $id]
        );
    }

    public function updateProfile(int $id, array $data): bool
    {
        return $this->DB->save(
            "UPDATE users SET username = :username, email = :email, phone = :phone WHERE id = :id",
            ['username' => $data['username'], 'email' => $data['email'], 'phone' => $data['phone'], 'id' => $id]
        );
    }

    public function findByUsername(string $username): ?array
    {
        $result = $this->DB->read(
            'SELECT * FROM users WHERE username = ? LIMIT 1',
            [$username]
        );

        return $result[0] ?? null;
    }

    public function findById(int $id): ?array
    {
        $result = $this->DB->read(
            'SELECT * FROM users WHERE id = ? LIMIT 1',
            [$id]
        );

        return $result[0] ?? null;
    }

    public function createUser(array $data): ?int
    {
        $saved = $this->DB->save(
            'INSERT INTO users (username, email, password_hash, role) VALUES (?, ?, ?, ?)',
            [
                $data['username'],
                $data['email'],
                $data['password_hash'],
                $data['role'],
            ]
        );

        return $saved ? (int) $this->DB->lastInsertId() : null;
    }
}
