<?php

use App\Controllers\RenderTemplatesController;
use App\Controllers\UserController;
use App\Core\Request;
use App\Core\Response;
use App\Core\Router;
use App\DependencyContainer\DependencyContainer;
use App\Repositories\UserRepository;
use App\Services\Builder\UserBuilder;
use App\Services\Session\SessionManager;
use App\Services\UserService;

$container = new DependencyContainer();

$container->set('sessionManager', function () {
    return new SessionManager();
});

$container->set('userBuilder', function () {
    return new UserBuilder();
});

$container->set('userRepository', function () {
    return new UserRepository();
});

$container->set(Response::class, function () {
    return new Response('', 200);
});

$container->set(Request::class, function () {
    $requestData = [
        'data' => $_REQUEST,
        'files' => $_FILES
    ];
    return new Request($requestData, $_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
});

$container->set(Router::class, function () {
    return new Router();
});

$container->setWithDependency('renderTemplatesController', function ($container) {
    $response = $container->get(Response::class);
    $request = $container->get(Request::class);
    return new RenderTemplatesController($request, $response);
});

$container->setWithDependency('userService', function ($container) {
    $userRepository = $container->get('userRepository');
    $sessionManager = $container->get('sessionManager');
    $userBuilder = $container->get('userBuilder');
    return new UserService($sessionManager, $userRepository, $userBuilder);
});

$container->setWithDependency('userController', function() use ($container) {
    $request = $container->get(Request::class);
    $sessionManager = $container->get('sessionManager');
    $userService = $container->get('userService');
    $response = $container->get(Response::class);
    return new UserController($request, $sessionManager, $userService, $response);
});

$container->set('errorHandler', function() {
    return function(Throwable $e, $response) {
        $errorMessage = 'Internal Server Error: ' . $e->getMessage();
        $response->setContent($errorMessage);
        $response->setStatusCode(500);
        $response->send();
        return $response;
    };
});

return $container;
