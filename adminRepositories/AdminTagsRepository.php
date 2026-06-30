<?php

namespace adminRepositories;
use adminControllers\AdminDatabaseController;

class AdminTagsRepository
{
    private AdminDatabaseController $DB;

    public function __construct()
    {
        $this->DB = new AdminDatabaseController();
    }

    public function getAll(): array
    {
        return $this->DB->read("SELECT * FROM tags ORDER BY name ASC") ?: [];
    }

    public function create(string $name): int
    {
        $this->DB->save("INSERT INTO tags (name) VALUES (:name)", ['name' => $name]);
        return (int)$this->DB->lastInsertId();
    }

    public function update(int $id, string $name): bool
    {
        return $this->DB->save("UPDATE tags SET name = :name WHERE id = :id", ['name' => $name, 'id' => $id]);
    }

    public function delete(int $id): bool
    {
        return $this->DB->save("DELETE FROM tags WHERE id = :id", ['id' => $id]);
    }
}