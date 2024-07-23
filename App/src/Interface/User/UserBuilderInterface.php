<?php

namespace App\Interface\User;

use App\Model\User;

interface UserBuilderInterface
{
    public function create(): UserBuilderInterface;
    public function setFirstName(string $first_name): UserBuilderInterface;
    public function setLastName(string $last_name): UserBuilderInterface;
    public function setEmail(string $email): UserBuilderInterface;
    public function setPasswordHash(string $password): UserBuilderInterface;
    public function getUser(): User;
}