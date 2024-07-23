<?php

declare(strict_types=1);

namespace App\Interface\Session;

interface SessionManagerInterface
{
    public function sessionStart(): void;
    public function checkSession(): bool;
    public function setSessionValue(string $key, string $value): void;
    public function setSessionValues(array $userData): void;
    public function getSessionValue(string $key);
    public function sessionDestroy(): void;
}