<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Baim\Belajar\PHP\MVC\App\Router;
use Baim\Belajar\PHP\MVC\Controller\HomeController;
use Baim\Belajar\PHP\MVC\Controller\ProductController;
use Baim\Belajar\PHP\MVC\Middleware\AuthMiddleware;

Router::add('GET', '/products/([0-9a-zA-Z]*)/categories/([0-9a-zA-Z]*)', ProductController::class, 'categories');

Router::add('GET', '/', HomeController::class, 'index');
Router::add('GET', '/hellow', HomeController::class, 'hellow', [AuthMiddleware::class]);
Router::add('GET', '/world', HomeController::class, 'world', [AuthMiddleware::class]);
Router::add('GET', '/author', HomeController::class, 'author', []);
Router::add('GET', '/login', HomeController::class, 'login', []);

Router::run();