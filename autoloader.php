<?php
spl_autoload_register(function ($class) {

    $className = basename(str_replace('\\', '/', $class));

    $paths = [
        __DIR__ . '/controllers/',
        __DIR__ . '/services/',
        __DIR__ . '/public/',
        __DIR__ . '/component/',
        __DIR__ . '/repositories/',


//      ==========  ADMIN =============
        __DIR__ . '/adminControllers/',
        __DIR__. '/adminServices/',
        __DIR__. '/adminRepositories/',
    ];

    foreach ($paths as $path) {
        $file = $path . $className . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

$envFile = __DIR__ . '/.env';

if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue; // Skip comments
        [$key, $value] = explode('=', $line, 2);
        $value = trim($value, "\"'"); // Remove quotes
        putenv(trim($key) . '=' . $value);
    }
}
