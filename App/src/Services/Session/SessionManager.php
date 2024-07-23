<?php

declare(strict_types=1);

namespace App\Services\Session;

use App\Core\Response;
use App\Interface\Session\SessionManagerInterface;

class SessionManager implements SessionManagerInterface
{
    /**
     * @return void
     */
    public function sessionStart(): void
    {
        session_start();
    }

    /**
     * @return bool
     */
    public function checkSession(): bool
    {
        if (!isset($_SESSION['email'])) {
            $response = new Response();
            $response->redirect('/');
            $response->send();
            exit;
        }

        return true;
    }

    /**
     * @param string $key
     * @param string $value
     * @return void
     */
    public function setSessionValue(string $key, string $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * @param array $userData
     * @return void
     */
    public function setSessionValues(array $userData): void
    {
        foreach ($userData as $key => $value) {
            $_SESSION[$key] = $value;
        }
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function getSessionValue(string $key): mixed
    {
        return $_SESSION[$key] ?? null;
    }

    /**
     * @return void
     */
    public function sessionDestroy(): void
    {
        session_start();
        if (session_status() == PHP_SESSION_ACTIVE) {
            session_destroy();
            setcookie(session_name(), "", time() - 3600, "/");
        }
    }
}