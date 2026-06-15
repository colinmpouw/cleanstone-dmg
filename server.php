<?php
$uri = $_SERVER['REQUEST_URI'];
$file = __DIR__ . parse_url($uri, PHP_URL_PATH);

// If it's a real file (css, js, images etc), serve it directly
if (is_file($file)) {
    return false;
}

// Otherwise route through index.php
require __DIR__ . '/index.php';