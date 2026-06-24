<?php

namespace repositories;
use controllers\DatabaseController;

class PasswordResetRepository
{
    private DatabaseController $DB;

    public function __construct()
    {
        $this->DB = new DatabaseController();
    }

    public function createToken(int $user_id, string $token): void
    {
        // verwijder oude tokens
        $this->DB->save(
            "DELETE FROM password_resets WHERE user_id = :user_id",
            ['user_id' => $user_id]
        );

        $this->DB->save(
            "INSERT INTO password_resets (user_id, token, expires_at)
             VALUES (:user_id, :token, DATE_ADD(NOW(), INTERVAL 15 MINUTE))",
            ['user_id' => $user_id, 'token' => $token]
        );
    }

    public function findToken(int $user_id, string $token): ?array
    {
        $rows = $this->DB->read(
            "SELECT * FROM password_resets
             WHERE user_id = :user_id
             AND token = :token
             AND expires_at > NOW()",
            ['user_id' => $user_id, 'token' => $token]
        );
        return $rows[0] ?? null;
    }

    public function deleteToken(int $user_id): void
    {
        $this->DB->save(
            "DELETE FROM password_resets WHERE user_id = :user_id",
            ['user_id' => $user_id]
        );
    }
}