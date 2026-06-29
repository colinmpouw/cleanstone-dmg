<?php

namespace adminControllers;

class AdminDiscountController
{

    public function __construct($router)
    {

        $router->get('/admin/discount-codes', [$this, 'DiscountPage']);
    }

    public function DiscountPage()
    {
        require_once __DIR__ . '/../admin/adminDiscountCodes.php';
        die();
    }

}