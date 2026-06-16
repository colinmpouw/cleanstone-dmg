<?php

namespace adminControllers;

class AdminAdvicesController
{

    public function __construct($router)
    {


        $router->get('/admin/adviesaanvragen', [$this, 'advicePage']);

    }
    public function advicePage(){
        require_once __DIR__ . '/../admin/adminAdvice.php';
        die();
    }
}