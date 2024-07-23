<?php

use App\Core\Response;
use App\Core\Request;

$container = require './config/dependencies.php';

$sessionManager = $container->get('sessionManager');
$response = $container->get(Response::class);
$errorHandler = $container->get('errorHandler');
$request = $container->get(Request::class);
$userService = $container->get('userService');
$baseService = $container->get('baseService');
$renderTemplatesController = $container->get('renderTemplatesController');
$userController = $container->get('userController');

return [
    [
        'method' => 'GET',
        'path' => '/',
        'handler' => function () use ($response, $errorHandler, $renderTemplatesController) {
            try {
                $renderTemplatesController->renderAuthTemplate();
            } catch (Throwable $e) {
                $errorHandler($e, $response);
            }
        }
    ],
    [
        'method' => 'GET',
        'path' => '/registration',
        'handler' => function () use ($response, $errorHandler, $renderTemplatesController){
            try {
                $renderTemplatesController->renderRegistrationTemplate();
            } catch (Throwable $e) {
                $errorHandler($e, $response);
            }
        }
    ],
    [
        'method' => 'GET',
        'path' => '/reset_password',
        'handler' => function () use ($response, $errorHandler, $renderTemplatesController) {
            try {
                $renderTemplatesController->renderResetPasswordTemplate();
            } catch (Throwable $e) {
                $errorHandler($e, $response);
            }
        }
    ],
    [
        'method' => 'POST',
        'path' => '/reset_password',
        'handler' => function () use ($response, $errorHandler, $userController) {
            try {
                $userController->resetPassword();
            } catch (Throwable $e) {
                $errorHandler($e, $response);
            }
        }
    ],
    [
        'method' => 'POST',
        'path' => '/registration',
        'handler' => function ()  use ($sessionManager, $response, $errorHandler, $userController){
            try {
                $userController->registration();
            } catch (Throwable $e) {
                $errorHandler($e, $response);
            }
        }
    ],
];
