<?php

namespace controllers;

use services\AuthService;

class AuthController
{
    private AuthService $authService;

    public function __construct($router)
    {
        $this->authService = new AuthService();

        $router->get('/login', [$this, 'showLogin']);
        $router->post('/login', [$this, 'processLogin']);
        $router->get('/register', [$this, 'showRegister']);
        $router->post('/register', [$this, 'processRegister']);
        $router->get('/logout', [$this, 'logout']);
        $router->get('/account', [$this, 'showAccount']);
        $router->get('/api/account/data', [$this, 'getAccountData']);
    }

    public function showLogin(): void
    {
        $this->authService->showLogin();
    }

    public function processLogin(): void
    {
        $this->authService->processLogin();
    }
    public function getAccountData(): void
    {
        $this->authService->getAccountData();
    }

    public function showRegister(): void
    {
        $this->authService->showRegister();
    }

    public function processRegister(): void
    {
        $this->authService->processRegister();
    }

    public function showAccount(): void
    {
        $this->authService->showAccount();
    }

    public function logout(): void
    {
        $this->authService->logout();
    }
}