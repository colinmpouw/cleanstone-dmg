<?php

namespace adminRepositories;

use adminControllers\AdminDatabaseController;

class AdminDashboardRepository
{
    private AdminDatabaseController $DB;

    public function __construct()
    {
        $this->DB = new AdminDatabaseController();
    }

    /* ========================================= */
    /* Dashboard Cards                           */
    /* ========================================= */

    public function getRevenueStats(): array
    {
        $row = $this->DB->read("
            SELECT
                COALESCE(SUM(total_price), 0) AS revenue
            FROM orders
            WHERE status IN (
                'paid',
                'processing',
                'shipped',
                'completed'
            )
        ");

        return [
            'value' => (float)($row[0]['revenue'] ?? 0),
            'delta' => 0,
            'direction' => 'up'
        ];
    }

    public function getOrderStats(): array
    {
        $row = $this->DB->read("
            SELECT COUNT(*) AS total
            FROM orders
        ");

        return [
            'value' => (int)($row[0]['total'] ?? 0),
            'delta' => 0,
            'direction' => 'up'
        ];
    }

    public function getProductStats(): array
    {
        $row = $this->DB->read("
            SELECT COUNT(*) AS total
            FROM products
        ");

        return [
            'value' => (int)($row[0]['total'] ?? 0),
            'delta' => 0,
            'direction' => 'up'
        ];
    }

    public function getAdviceStats(): array
    {
        $row = $this->DB->read("
            SELECT COUNT(*) AS total
            FROM advice_requests
            WHERE status = 'open'
        ");

        return [
            'value' => (int)($row[0]['total'] ?? 0),
            'delta' => 0,
            'direction' => 'up'
        ];
    }

    /* ========================================= */
    /* Revenue                                   */
    /* ========================================= */

    public function getRevenueTotal(): float
    {
        $row = $this->DB->read("
            SELECT
                COALESCE(SUM(total_price), 0) AS total
            FROM orders
            WHERE status IN (
                'paid',
                'processing',
                'shipped',
                'completed'
            )
        ");

        return (float)($row[0]['total'] ?? 0);
    }

    public function getRevenueChart(): array
    {
        return $this->DB->read("
            SELECT
                DATE_FORMAT(created_at, '%b') AS label,
                SUM(total_price) AS value
            FROM orders
            WHERE status IN (
                'paid',
                'processing',
                'shipped',
                'completed'
            )
            GROUP BY MONTH(created_at)
            ORDER BY MONTH(created_at)
        ");
    }

    /* ========================================= */
    /* Categories                                */
    /* ========================================= */

    public function getCategoryDistribution(): array
    {
        return $this->DB->read("
            SELECT
                c.name AS label,
                COUNT(DISTINCT p.id) AS value
            FROM categories c
            LEFT JOIN products p
                ON p.category_id = c.id
            GROUP BY c.id, c.name
            ORDER BY value DESC
        ");
    }

    /* ========================================= */
    /* Recent Orders                             */
    /* ========================================= */

    public function getRecentOrders(): array
    {
        return $this->DB->read("
            SELECT
                o.id,
                u.username AS customer,
                o.created_at AS date,
                o.total_price AS amount,
                o.status
            FROM orders o
            LEFT JOIN users u
                ON u.id = o.user_id
            ORDER BY o.created_at DESC
            LIMIT 10
        ");
    }

    /* ========================================= */
    /* Advice Requests                           */
    /* ========================================= */

    public function getRecentAdvice(): array
    {
        return $this->DB->read("
            SELECT
                ar.id,
                ar.name,
                ar.stone_type AS subject,
                ar.created_at AS date,
                ar.status,

                EXISTS(
                    SELECT 1
                    FROM advice_images ai
                    WHERE ai.request_id = ar.id
                ) AS has_photo

            FROM advice_requests ar
            ORDER BY ar.created_at DESC
            LIMIT 10
        ");
    }
}