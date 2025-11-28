<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Baim\Belajar\PHP\MVC\App\Router;
use Baim\Belajar\PHP\MVC\Controller\HomeController;

Router::add('GET', '/products/([0-9a-zA-Z]*)/categories/([0-9a-zA-Z]*)', ProductController::class, 'categories');

Router::add('GET', '/', HomeController::class, 'index');

Router::run();