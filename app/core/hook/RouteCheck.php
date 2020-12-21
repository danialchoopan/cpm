<?php
//check route
use App\core\Route;

if (!Route::$founded) {
    echo \App\core\View::Create('messages.404');
    http_response_code(404);
}