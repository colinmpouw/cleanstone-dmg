<?php

namespace adminControllers;



class AdminUsersController
{


    public function __construct($router)
    {

        $router->get('/admin/login', [$this, 'adminLoginPage']);


    }

  public function adminLoginPage(){

        require_once __DIR__ . '/../admin/adminLogin.php';
        die();
  }
}
