<?php
require_once __DIR__ . '/autoloader.php';
require_once __DIR__ . '/Router.php';

session_start();

$router = new Router();

foreach (glob(__DIR__ . '/controllers/*.php') as $file) {
    $className = pathinfo($file, PATHINFO_FILENAME);
    if ($className === 'DatabaseController') continue;

    $fullClass = 'controllers\\' . $className;
    new $fullClass($router);
}
foreach (glob(__DIR__ . '/adminControllers/*.php') as $file) {
    $className = pathinfo($file, PATHINFO_FILENAME);
    $fullClass = 'adminControllers\\' . $className;
    new $fullClass($router);
}

$router->dispatch();