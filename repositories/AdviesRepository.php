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

    public function getMessages(int $request_id): array
    {
        return $this->DB->read(
            "SELECT am.*, u.username, u.role FROM advice_messages am
         JOIN users u ON am.user_id = u.id
         WHERE am.request_id = :request_id
         ORDER BY am.created_at ASC",
            ['request_id' => $request_id]
        ) ?: [];
    }

    public function sendMessage(int $request_id, int $user_id, string $message): void
    {
        $this->DB->save(
            "INSERT INTO advice_messages (request_id, user_id, message)
         VALUES (:request_id, :user_id, :message)",
            ['request_id' => $request_id, 'user_id' => $user_id, 'message' => $message]
        );
    }

    public function updateStatus(int $id, string $status): void
    {
        $this->DB->save(
            "UPDATE advice_requests SET status = :status WHERE id = :id",
            ['status' => $status, 'id' => $id]
        );
    }

    public function deleteRequest(int $id, int $user_id): bool
    {
        return $this->DB->save(
            "DELETE FROM advice_requests WHERE id = :id AND user_id = :user_id",
            ['id' => $id, 'user_id' => $user_id]
        );
    }
}

