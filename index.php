<?php
require_once __DIR__ . '/autoloader.php';
require_once __DIR__ . '/Router.php';

$router = new Router();

foreach (glob(__DIR__ . '/controllers/*.php') as $file) {
    $className = pathinfo($file, PATHINFO_FILENAME);
    new $className($router);
}

$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);