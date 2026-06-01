<?php

namespace controllers;

class HomController
{
    public function __construct($router)
    {

        $router->get('/home', [$this, 'pageHome']);
        $router->get('/', [$this, 'pageHome']);
        $router->get('/test', [$this, 'testPage']);

    }

    public function pageHome()
    {
        require __DIR__ . '/../public/home.php';
    }
public function testPage(){
        require __DIR__ . '/../public/test.php';
}

}