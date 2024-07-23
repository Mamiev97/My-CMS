<?php

namespace App\Interface\User;

use App\Interface\Session\SessionManagerInterface;
use App\Repositories\UserRepository;
use App\Services\Builder\UserBuilder;

interface UserServiceInterface
{
    public function __construct(SessionManagerInterface $sessionManager, UserRepository $userRepository, UserBuilder $userBuilder);
}