<?php

namespace App\core;

use Jenssegers\Blade\Blade;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class View
{
    public static function Create($viewName, $params = [])
    {
        extract($params);
        $blade = new Blade(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR,
            dirname(__DIR__) . DIRECTORY_SEPARATOR . 'cache');
        return $blade->make($viewName, $params)->render();
    }

}