<?php

namespace controllers;

class HomController
{
    public function __construct($router)
    {

        $router->get('/home', [$this, 'pageHome']);
        $router->get('/', [$this, 'pageHome']);

    }

    public function pageHome()
    {
        require __DIR__ . '/../public/home.php';
    }


}