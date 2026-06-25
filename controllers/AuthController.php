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
        $router->get('/mijn-gegevens', [$this, 'showGegevens']);
        $router->get('/account/mijn-gegevens', [$this, 'showGegevens']);
        $router->post('/api/account/mijn-gegevens/profiel', [$this, 'updateProfiel']);
        $router->get('/api/account/gegevens', [$this, 'getGegevens']);
    }

    public function showLogin(): void
    {
        $this->authService->showLogin();
    }

    public function getGegevens(): void
    {
        $this->authService->getGegevens();
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

    public function showGegevens(): void
    {
        $this->authService->showGegevens();
    }

    public function updateProfiel(): void
    {
        $this->authService->updateProfiel();
    }

    public function updateWachtwoord(): void
    {
        $this->authService->updateWachtwoord();
    }

    public function logout(): void
    {
        $this->authService->logout();
    }
}