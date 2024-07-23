<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\BaseController;
use App\Core\Request;
use App\Core\Response;
use App\Services\Session\SessionManager;
use App\Services\UserService;

class UserController extends BaseController
{
    private SessionManager $sessionManager;
    protected Request $request;
    protected Response $response;
    private UserService $userService;

    /**
     * @param Request $request
     * @param SessionManager $sessionManager
     * @param UserService $userService
     * @param Response $response
     */
    public function __construct(Request $request, SessionManager $sessionManager, UserService $userService, Response $response)
    {
        parent::__construct($request, $response);
        $this->sessionManager = $sessionManager;
        $this->userService = $userService;
    }
}