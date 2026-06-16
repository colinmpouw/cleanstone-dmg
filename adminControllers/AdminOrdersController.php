<?php

namespace adminControllers;

class AdminOrdersController
{
    public function __construct($router)
    {


        $router->get('/admin/bestellingen', [$this, 'ordersPage']);

    }
    public function ordersPage(){
        require_once __DIR__ . '/../admin/adminOrders.php';
        die();
    }
}