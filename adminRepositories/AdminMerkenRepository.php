<?php

namespace adminRepositories;
use adminControllers\AdminDatabaseController;

class AdminMerkenRepository
{
    private AdminDatabaseController $DB;

    public function __construct()
    {
        $this->DB = new AdminDatabaseController();
    }

    public function getAll(): array
    {
        return $this->DB->read("SELECT * FROM brands ORDER BY name ASC") ?: [];
    }

    public function create(array $data): int
    {
        $this->DB->save(
            "INSERT INTO brands (name, discription, logo) VALUES (:name, :discription, :logo)",
            $data
        );
        return (int)$this->DB->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        return $this->DB->save(
            "UPDATE brands SET name = :name, discription = :discription, logo = :logo WHERE id = :id",
            array_merge($data, ['id' => $id])
        );
    }

    public function delete(int $id): bool
    {
        return $this->DB->save(
            "DELETE FROM brands WHERE id = :id",
            ['id' => $id]
        );
    }
}