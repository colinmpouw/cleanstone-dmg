<?php

namespace adminRepositories;
use adminControllers\AdminDatabaseController;

class AdminCategoryRepository
{
    private AdminDatabaseController $DB;

    public function __construct()
    {
        $this->DB = new AdminDatabaseController();
    }

    public function getAll(): array
    {
        return $this->DB->read("SELECT * FROM categories ORDER BY parent_id IS NULL DESC, parent_id ASC, name ASC") ?: [];
    }

    public function create(array $data): int
    {
        $this->DB->save(
            "INSERT INTO categories (parent_id, name, slug) VALUES (:parent_id, :name, :slug)",
            $data
        );
        return (int)$this->DB->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        return $this->DB->save(
            "UPDATE categories SET parent_id = :parent_id, name = :name, slug = :slug WHERE id = :id",
            array_merge($data, ['id' => $id])
        );
    }

    public function delete(int $id): bool
    {
        return $this->DB->save("DELETE FROM categories WHERE id = :id", ['id' => $id]);
    }
}