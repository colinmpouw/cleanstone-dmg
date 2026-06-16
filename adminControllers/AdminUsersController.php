<?php

namespace adminControllers;



class AdminUsersController
{


    public function __construct($router)
    {

        $router->get('/admin/login', [$this, 'adminLoginPage']);
        $router->get('/admin/gebruikers', [$this, 'adminUsersPage']);

    }

  public function adminLoginPage(){

        require_once __DIR__ . '/../admin/adminLogin.php';
        die();
  }
    public function adminUsersPage(){

        require_once __DIR__ . '/../admin/adminUsers.php';
        die();
    }
}
