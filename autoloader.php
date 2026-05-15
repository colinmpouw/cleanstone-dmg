<?php
spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/controllers/',
        __DIR__ . '/services/',
        __DIR__ . '/public/',
        __DIR__ . '/component/',
    ];

    foreach ($paths as $path) {
        $file = $path . $class . '.php';
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
