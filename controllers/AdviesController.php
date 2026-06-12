<?php

namespace controllers;

class AdviesController
{
    public function __construct($router)
    {

        $router->get('/advies', [$this, 'pageadvie']);
    }

    public function pageadvie()
    {
        require __DIR__ . '/../public/advies.php';
    }

}