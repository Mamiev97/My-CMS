<?php

require_once 'vendor/autoload.php';
$container = require_once './config/dependencies.php';

use App\Core\Request;
use App\Core\Router;

$sessionManager = $container->get('sessionManager');
$sessionManager->sessionStart();

$request = $container->get(Request::class);

$router = $container->get(Router::class);

$processRequest = $router->processRequest($request);