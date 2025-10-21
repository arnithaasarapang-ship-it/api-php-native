<?php

use Src\Router;
use Src\Controllers\UserController;

// Panggil file router dan controller
require __DIR__ . '/../src/Router.php';
require __DIR__ . '/../src/Controllers/UserController.php';

// Buat instance router dan controller
$router = new Router();
$userController = new UserController();

// Definisikan route
$router->add('GET', '/api/v1/users', [$userController, 'index']);
$router->add('GET', '/api/v1/users/{id}', [$userController, 'show']);

// Jalankan router
$router->run();
