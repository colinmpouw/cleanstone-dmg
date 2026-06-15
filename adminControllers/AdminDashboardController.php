<?php

namespace adminControllers;



class AdminDashboardController
{
    public function __construct($router)
    {

        $router->get('/admin', [$this, 'adminURL']);
        $router->get('/admin/dashboard', [$this, 'dashboardPage']);

    }
    public function adminURL(){
        $user = $_SESSION['user'] ?? null;
        if (!$user || $user['role'] !== 'admin') {
            header('Location: /admin/login');
            die();
        }

        header('Location: /admin/dashboard');
        die();
    }
    public function dashboardPage(){
        $user = $_SESSION['user'] ?? null;
        if (!$user || $user['role'] !== 'admin') {
            header('Location: /admin/login');
            die();
        }
        require_once __DIR__ . '/../admin/dashboard.php';
        die();
    }
}