<?php

namespace controllers;
use services\AdviesService;

class HomeController
{
    private AdviesService $adviesService;

    public function __construct($router)
    {
        $this->adviesService = new AdviesService();

        $router->get('/home', [$this, 'pageHome']);
        $router->get('/', [$this, 'pageHome']);
        $router->get('/test', [$this, 'testPage']);
    }

    public function pageHome()
    {
        $homeExisting = null;
        if (!empty($_SESSION['user']['id'])) {
            $requests = $this->adviesService->getRequestsByUser($_SESSION['user']['id']);
            $homeExisting = $requests[0] ?? null;
        }
        require __DIR__ . '/../public/home.php';
    }

    public function testPage()
    {
        require __DIR__ . '/../public/test.php';
    }
}