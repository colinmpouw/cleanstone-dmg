<?php

namespace controllers;

class OveronsController
{
    public function __construct($router)
    {
        // Route for the Over Ons page
        $router->get('/overons', [$this, 'pageOverons']);
        // also register a friendly path
        $router->get('/over-ons', [$this, 'pageOverons']);
    }

    public function pageOverons()
    {
        require __DIR__ . '/../public/overons.php';
    }

}