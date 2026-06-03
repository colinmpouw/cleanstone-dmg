<?php

namespace controllers;

class ProductenController
{
    public function __construct($router)
    {

        $router->get('/producten', [$this, 'pageProducten']);

    }

    public function pageProducten()
    {
        require __DIR__ . '/../public/producten.php';
    }

}