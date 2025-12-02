<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Baim\Belajar\PHP\MVC\App\Router;
use Baim\Belajar\PHP\MVC\Controller\HomeController;
use Baim\Belajar\PHP\MVC\Controller\UserController;
use Baim\Belajar\PHP\MVC\Config\Database;
use Baim\Belajar\PHP\MVC\Middleware\MustLoginMiddleware;
use Baim\Belajar\PHP\MVC\Middleware\MustNotLoginMiddleware;

Database::getConnection('prod');

// HOME CONTROLLER
Router::add('GET', '/', HomeController::class, 'index', []);

// USER CONTROLLER
Router::add('GET', '/users/register', UserController::class, 'register', [MustNotLoginMiddleware::class]);
Router::add('POST', '/users/register', UserController::class, 'postRegister', [MustNotLoginMiddleware::class]);
Router::add('GET', '/users/login', UserController::class, 'login', [MustNotLoginMiddleware::class]);
Router::add('POST', '/users/login', UserController::class, 'postLogin', [MustNotLoginMiddleware::class]);
Router::add('GET', '/users/logout', UserController::class, 'logout', [MustLoginMiddleware::class]);
Router::add('GET', '/users/profile', UserController::class, 'updateProfile', [MustLoginMiddleware::class]);
Router::add('POST', '/users/profile', UserController::class, 'postUpdateProfile', [MustLoginMiddleware::class]);
Router::add('GET', '/users/password', UserController::class, 'updatePassword', [MustLoginMiddleware::class]);
Router::add('POST', '/users/password', UserController::class, 'PostUpdatePassword', [MustLoginMiddleware::class]);

Router::run();