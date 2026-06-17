<?php

namespace adminControllers;

class AdminAdvicesController
{

    public function __construct($router)
    {


        $router->get('/admin/adviesaanvragen', [$this, 'advicePage']);
        $router->get('/admin/advieschat', [$this, 'adviceChatPage']);

    }
    public function advicePage(){
        require_once __DIR__ . '/../admin/adminAdvice.php';
        die();
    }

    public function adviceChatPage(){
        require_once __DIR__ . '/../admin/adminAdviceChat.php';
        die();
    }
}