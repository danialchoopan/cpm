<?php
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$file = __DIR__ . '/public' . $uri;

if (is_file($file)) {
    // Manually handle content type for CSS
    if (pathinfo($file, PATHINFO_EXTENSION) === 'css') {
        header('Content-Type: text/css');
    }
    readfile($file);
    return true;
}

$_GET['uri'] = ltrim($uri, '/');
chdir(__DIR__ . '/public');
require_once 'index.php';
