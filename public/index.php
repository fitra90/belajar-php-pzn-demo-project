<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Baim\Belajar\PHP\MVC\App\Router;
use Baim\Belajar\PHP\MVC\Controller\HomeController;
use Baim\Belajar\PHP\MVC\Controller\UserController;
use Baim\Belajar\PHP\MVC\Config\Database;

Database::getConnection('prod');

// HOME CONTROLLER
Router::add('GET', '/', HomeController::class, 'index');

// USER CONTROLLER
Router::add('GET', '/users/register', UserController::class, 'register', []);
Router::add('POST', '/users/register', UserController::class, 'postRegister', []);
Router::add('GET', '/users/login', UserController::class, 'login', []);
Router::add('POST', '/users/login', UserController::class, 'postLogin', []);

Router::run();