<?php

namespace adminControllers;

class AdminMerkenController
{
    public function __construct($router)
    {

        $router->get('/admin/merken', [$this, 'MerkenPage']);
    }

    public function MerkenPage()
    {
        require_once __DIR__ . '/../admin/adminMerken.php';
        die();
    }

}