<?php

namespace controllers;
class databaseController
{
    private $pdo;

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

    public function connect()
    {
        return $this->pdo;
    }

    // Read data (SELECT query with parameters)
    public function read($query, $params = [])
    {
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);
            $data = $stmt->fetchAll();
            return !empty($data) ? $data : false;
        } catch (PDOException $e) {

            return false;
        }
    }

    // Save data (INSERT, UPDATE, DELETE with parameters)
    public function save($query, $params = [])
    {
        try {
            $stmt = $this->pdo->prepare($query);
            return $stmt->execute($params);
        } catch (PDOException $e) {

            return false;
        }
    }

    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }

}