<?php

namespace adminControllers;

use PDO;
use PDOException;

class AdminDatabaseController
{
    private PDO $pdo;

    public function __construct()
    {
        $config = require __DIR__ . '/../config/db_config.php';

        try {
            $dsn = "mysql:host={$config['servername']};dbname={$config['dbname']};charset=utf8mb4";
            $this->pdo = new PDO($dsn, $config['username'], $config['password'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // show error
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // default
            ]);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }


    // Read data (SELECT query with parameters)
    public function read(string $query, array $params = []): array
    {
        $user = $_SESSION['user'] ?? null;

        if (
            empty($user['id']) ||
            empty($user['role']) ||
            $user['role'] !== 'admin'
        ) {
            http_response_code(403);
            return [];
        }

        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);

            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

        } catch (PDOException $e) {
            file_put_contents(
                __DIR__ . '/../admin-debug.log',
                '[' . date('Y-m-d H:i:s') . '] SQL ERROR: ' . $e->getMessage() .
                ' | Query: ' . $query .
                ' | Params: ' . print_r($params, true) . PHP_EOL,
                FILE_APPEND
            );

            return [];
        }
    }

    // Save data (INSERT, UPDATE, DELETE with parameters)
    public function save(string $query, array $params = []): bool
    {
        $user = $_SESSION['user'] ?? null;

        if (
            empty($user['id']) ||
            empty($user['role']) ||
            $user['role'] !== 'admin'
        ) {
            http_response_code(403);
            return false;
        }
        try {
            $stmt = $this->pdo->prepare($query);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            file_put_contents(__DIR__ . '/../admin-debug.log', '[' . date('Y-m-d H:i:s') . '] SQL ERROR: ' . $e->getMessage() . ' | Query: ' . $query . ' | Params: ' . print_r($params, true) . PHP_EOL, FILE_APPEND);
            return false;
        }
    }

    public function lastInsertId(): string
    {
        return $this->pdo->lastInsertId();
    }

}