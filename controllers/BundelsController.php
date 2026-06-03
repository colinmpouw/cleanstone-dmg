<?php

namespace controllers;

class BundelsController
{
    public function __construct($router)
    {

        $router->get('/bundels', [$this, 'bundelsPage']);


    }

    public function bundelsPage()
    {
        require __DIR__ . '/../public/bundels.php';
    }


}