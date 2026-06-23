<?php

namespace adminRepositories;
use adminControllers\AdminDatabaseController;
use controllers\DatabaseController;

class AdminAdvicesRepository
{
    private DatabaseController $DB;

    public function __construct()
    {
        $this->DB = new AdminDatabaseController();
    }

    public function getAllRequests(): array
    {
        return $this->DB->read("
            SELECT ar.*, u.username,
                (SELECT filename FROM advice_images WHERE request_id = ar.id LIMIT 1) as first_image
            FROM advice_requests ar
            JOIN users u ON ar.user_id = u.id
            ORDER BY ar.created_at DESC
        ") ?: [];
    }

    public function countByStatus(): array
    {
        $rows = $this->DB->read("
            SELECT status, COUNT(*) as count
            FROM advice_requests
            GROUP BY status
        ") ?: [];

        $counts = ['open' => 0, 'in_behandeling' => 0, 'gesloten' => 0];
        foreach ($rows as $row) {
            $counts[$row['status']] = (int)$row['count'];
        }
        return $counts;
    }

}