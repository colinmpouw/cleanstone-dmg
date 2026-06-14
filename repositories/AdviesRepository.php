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
}