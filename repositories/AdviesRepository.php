<?php

namespace repositories;
use controllers\DatabaseController;

class AdviesRepository
{
    private DatabaseController $DB;

    public function __construct()
    {
        $this->DB = new DatabaseController();
    }

    public function createRequest(array $data): int
    {
        $this->DB->save(
            "INSERT INTO advice_requests (user_id, name, email, phone, stone_type, stone_location, message)
             VALUES (:user_id, :name, :email, :phone, :stone_type, :stone_location, :message)",
            $data
        );
        return (int)$this->DB->lastInsertId();
    }

    public function saveImage(int $request_id, string $filename): void
    {
        $this->DB->save(
            "INSERT INTO advice_images (request_id, filename) VALUES (:request_id, :filename)",
            ['request_id' => $request_id, 'filename' => $filename]
        );
    }

    public function getRequestById(int $id): ?array
    {
        $rows = $this->DB->read(
            "SELECT ar.*, u.username FROM advice_requests ar
         JOIN users u ON ar.user_id = u.id
         WHERE ar.id = :id",
            ['id' => $id]
        );
        return $rows[0] ?? null;
    }

    public function getImages(int $request_id): array
    {
        return $this->DB->read(
            "SELECT filename FROM advice_images WHERE request_id = :request_id",
            ['request_id' => $request_id]
        ) ?: [];
    }
    public function getRequestsByUser(int $user_id): array
    {
        return $this->DB->read(
            "SELECT * FROM advice_requests WHERE user_id = :user_id ORDER BY created_at DESC",
            ['user_id' => $user_id]
        ) ?: [];
    }
}

