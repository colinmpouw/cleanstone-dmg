<?php

namespace adminRepositories;
use adminControllers\AdminDatabaseController;

class AdminDiscountRepository
{
    private AdminDatabaseController $DB;

    public function __construct()
    {
        $this->DB = new AdminDatabaseController();
    }

    public function getAll(): array
    {
        return $this->DB->read(
            "SELECT * FROM discount_codes ORDER BY created_at DESC"
        ) ?: [];
    }

    public function create(array $data): int
    {
        $this->DB->save(
            "INSERT INTO discount_codes (code, type, value, min_order_amount, max_discount, usage_limit, start_date, end_date, status)
             VALUES (:code, :type, :value, :min_order_amount, :max_discount, :usage_limit, :start_date, :end_date, :status)",
            $data
        );
        return (int)$this->DB->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        return $this->DB->save(
            "UPDATE discount_codes SET code = :code, type = :type, value = :value,
             min_order_amount = :min_order_amount, max_discount = :max_discount,
             usage_limit = :usage_limit, start_date = :start_date, end_date = :end_date,
             status = :status WHERE id = :id",
            array_merge($data, ['id' => $id])
        );
    }

    public function delete(int $id): bool
    {
        return $this->DB->save(
            "DELETE FROM discount_codes WHERE id = :id",
            ['id' => $id]
        );
    }

    public function toggleStatus(int $id, string $status): bool
    {
        return $this->DB->save(
            "UPDATE discount_codes SET status = :status WHERE id = :id",
            ['status' => $status, 'id' => $id]
        );
    }
}