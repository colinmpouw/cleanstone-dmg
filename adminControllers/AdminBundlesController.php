<?php

namespace adminControllers;

class AdminBundlesController
{
    public function __construct($router)
    {


        $router->get('/admin/bundels', [$this, 'bundlesPage']);

    }
    public function bundlesPage(){
        require_once __DIR__ . '/../admin/adminBundles.php';
        die();
    }
}