<?php

namespace controllers;
class PageController
{
    public function __construct($router)
    {

        $router->get('/', [$this, 'pageHome']);

    }

    public function pageHome()
    {
        require __DIR__ . '/../public/home.php';
    }


}