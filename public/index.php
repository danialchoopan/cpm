<?php

require_once '../vendor/autoload.php';

if (file_exists(__DIR__ . '/../.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();
}

require_once '../app/routes/web.php';
require_once '../app/routes/api.php';
require_once '../app/core/hook/RouteCheck.php';
