<?php

namespace adminControllers;



class AdminDashboardController
{
    public function __construct($router)
    {

        $router->get('/admin', [$this, 'dashboardPage']);
        $router->get('/admin/dashboard', [$this, 'dashboardPage']);

    }

    public function dashboardPage(){
        echo "AdminDashboardController loaded<br>";
        require_once __DIR__ . '/../admin/dashboard.php';
    }
}