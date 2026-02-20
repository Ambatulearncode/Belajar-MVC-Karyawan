<?php

namespace Core;

class Auth
{
    private static function startSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function login(array $user): void
    {
        self::startSession();

        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'email' => $user['email'],
            'role' => $user['role']
        ];

        session_regenerate_id(true);
    }

    public static function logout(): void
    {
        self::startSession();

        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        session_destroy();
    }

    public static function check(): bool
    {
        self::startSession();
        return isset($_SESSION['user']);
    }

    public static function isAdmin(): bool
    {
        self::startSession();
        return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
    }

    public static function user(): ?array
    {
        self::startSession();
        return $_SESSION['user'] ?? null;
    }

    public function id(): ?int
    {
        self::startSession();
        return $_SESSION['user']['id'] ?? null;
    }
    public static function requireLogin(): void
    {
        if (!self::check()) {
            header('Location: index.php?url=auth&action=login');
            exit;
        }
    }

    public static function requireAdmin(): void
    {
        self::requireLogin();

        if (!self::isAdmin()) {
            header('Location: index.php?url=auth&action=unauthorized');
            exit;
        }
    }
}
