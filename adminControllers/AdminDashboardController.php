<?php

namespace adminControllers;

class AdminDashboardController
{
    public function __construct($router)
    {
        $router->get('/admin', [$this, 'adminURL']);
        $router->get('/admin/dashboard', [$this, 'dashboardPage']);

        // ✅ NEW API ROUTES
        $router->get('/api/admin/dashboard/stats', [$this, 'stats']);
        $router->get('/api/admin/dashboard/revenue', [$this, 'revenue']);
        $router->get('/api/admin/dashboard/categories', [$this, 'categories']);
        $router->get('/api/admin/dashboard/orders', [$this, 'orders']);
        $router->get('/api/admin/dashboard/advice', [$this, 'advice']);
    }

    public function adminURL()
    {
        $user = $_SESSION['user'] ?? null;
        if (!$user || $user['role'] !== 'admin') {
            header('Location: /admin/login');
            exit();
        }

        header('Location: /admin/dashboard');
        exit();
    }

    public function dashboardPage()
    {
        $user = $_SESSION['user'] ?? null;
        if (!$user || $user['role'] !== 'admin') {
            http_response_code(403);
        }
        require_once __DIR__ . '/../admin/adminDashboard.php';
        exit();
    }

    /* ===================================================== */
    /* ✅ STATS                                                */
    /* ===================================================== */

    public function stats()
    {
        header('Content-Type: application/json');

        echo json_encode([
            "revenue" => ["value" => 15200, "delta" => 12, "direction" => "up"],
            "orders" => ["value" => 312, "delta" => 5, "direction" => "up"],
            "active_products" => ["value" => 72, "delta" => 2, "direction" => "up"],
            "advice_requests" => ["value" => 6, "delta" => -1, "direction" => "down"]
        ]);

        exit();
    }

    /* ===================================================== */
    /* ✅ REVENUE                                             */
    /* ===================================================== */

    public function revenue()
    {
        header('Content-Type: application/json');

        echo json_encode([
            "total" => 112000,
            "points" => [
                ["label" => "Jan", "value" => 5000],
                ["label" => "Feb", "value" => 6800],
                ["label" => "Mar", "value" => 7200],
                ["label" => "Apr", "value" => 8500],
                ["label" => "May", "value" => 9300],
                ["label" => "Jun", "value" => 11000],
                ["label" => "Jul", "value" => 9700],
                ["label" => "Aug", "value" => 10200],
                ["label" => "Sep", "value" => 11500],
                ["label" => "Oct", "value" => 12000],
                ["label" => "Nov", "value" => 12800],
                ["label" => "Dec", "value" => 13500]
            ]
        ]);

        exit();
    }

    /* ===================================================== */
    /* ✅ CATEGORIES                                          */
    /* ===================================================== */

    public function categories()
    {
        header('Content-Type: application/json');

        echo json_encode([
            ["label" => "Reiniging", "value" => 48],
            ["label" => "Impregnering", "value" => 33],
            ["label" => "Onderhoud", "value" => 25],
            ["label" => "Bundels", "value" => 18],
            ["label" => "Overig", "value" => 12]
        ]);

        exit();
    }

    /* ===================================================== */
    /* ✅ ORDERS                                              */
    /* ===================================================== */

    public function orders()
    {
        header('Content-Type: application/json');

        echo json_encode([
            [
                "id" => "CS-3001",
                "customer" => "Jan de Vries",
                "date" => "2026-06-14",
                "amount" => 89.95,
                "status" => "verzonden"
            ],
            [
                "id" => "CS-3002",
                "customer" => "Lisa Bakker",
                "date" => "2026-06-15",
                "amount" => 149.50,
                "status" => "verwerking"
            ],
            [
                "id" => "CS-3003",
                "customer" => "Ali Hassan",
                "date" => "2026-06-16",
                "amount" => 59.99,
                "status" => "betaald"
            ]
        ]);

        exit();
    }

    /* ===================================================== */
    /* ✅ ADVICE REQUESTS                                     */
    /* ===================================================== */

    public function advice()
    {
        header('Content-Type: application/json');

        echo json_encode([
            [
                "name" => "Karin Meijer",
                "subject" => "Travertin terras",
                "date" => "2026-06-14",
                "status" => "nieuw",
                "has_photo" => true
            ],
            [
                "name" => "Tom Janssen",
                "subject" => "Natuursteen vloer",
                "date" => "2026-06-15",
                "status" => "behandeling",
                "has_photo" => false
            ],
            [
                "name" => "Emma Visser",
                "subject" => "Marmer onderhoud",
                "date" => "2026-06-16",
                "status" => "beantwoord",
                "has_photo" => true
            ]
        ]);

        exit();
    }
}