<?php

declare(strict_types=1);

namespace App\Services\Builder;

use App\Interface\User\UserBuilderInterface;
use App\Model\User;

class UserBuilder implements UserBuilderInterface
{
    private User $user;

    /**
     * @return UserBuilderInterface
     */
    public function create(): UserBuilderInterface
    {
        $this->user = new User();
        return $this;
    }

    /**
     * @param string $first_name
     * @return UserBuilderInterface
     */
    public function setFirstName(string $first_name): UserBuilderInterface
    {
        $this->user->setFirstName($first_name);
        return $this;
    }

    /**
     * @param string $password
     * @return UserBuilderInterface
     */
    public function setPasswordHash(string $password): UserBuilderInterface
    {
        $this->user->setPasswordHash($password);
        return $this;
    }

    /**
     * @param string $email
     * @return UserBuilderInterface
     */
    public function setEmail(string $email): UserBuilderInterface
    {
        $this->user->setEmail($email);
        return $this;
    }

    /**
     * @param string $last_name
     * @return UserBuilderInterface
     */
    public function setLastName(string $last_name): UserBuilderInterface
    {
        $this->user->setLastName($last_name);
        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        $result = $this->user;
        $this->create();
        return $result;
    }
}