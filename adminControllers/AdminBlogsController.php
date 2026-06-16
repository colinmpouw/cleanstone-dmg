<?php

namespace adminControllers;

class AdminBlogsController
{
    public function __construct($router)
    {


        $router->get('/admin/blog', [$this, 'blogPage']);

    }
    public function blogPage(){
        require_once __DIR__ . '/../admin/adminBlog.php';
        die();
    }
}