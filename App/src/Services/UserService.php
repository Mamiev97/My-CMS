<?php

namespace App\Services;

use App\Interface\Session\SessionManagerInterface;
use App\Interface\User\UserServiceInterface;
use App\Repositories\UserRepository;
use App\Services\Builder\UserBuilder;


class UserService implements UserServiceInterface
{
    private  SessionManagerInterface $sessionManager;
    private UserRepository $userRepository;
    private UserBuilder $userBuilder;
    public function __construct(SessionManagerInterface $sessionManager, UserRepository $userRepository, UserBuilder $userBuilder)
    {
        $this->userBuilder = $userBuilder;
        $this->userRepository = $userRepository;
        $this->sessionManager = $sessionManager;
    }
}