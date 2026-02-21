<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../utils/helpers.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$url = $_GET['url'] ?? 'auth';
$action = $_GET['action'] ?? 'login';
$id = $_GET['id'] ?? null;

use Core\Auth;

switch ($url) {
    case "auth":
        $controller = new App\Controllers\AuthController();

        switch ($action) {
            case 'login':
                $controller->login();
                break;
            case 'authenticate':
                $controller->authenticate();
                break;
            case 'logout':
                $controller->logout();
                break;
            case 'dashboard':
                $controller->dashboard();
                break;
            case 'unauthorized':
                $controller->unauthorized();
                break;
            default:
                $controller->login();
                break;
        }
        break;

    case "karyawan":
        Auth::requireLogin();

        if (!Auth::isAdmin()) {
            header('Location: index.php?url=auth&action=unauthorized');
            exit();
        }

        $controller = new App\Controllers\KaryawanController();

        switch ($action) {
            case 'index':
                $controller->index();
                break;
            case 'create':
                $controller->create();
                break;
            case 'store':
                $controller->store();
                break;
            case 'edit':
                if ($id) {
                    $controller->edit((int)$id);
                } else {
                    $controller->index();
                }
                break;
            case 'update':
                if ($id) {
                    $controller->update((int)$id);
                } else {
                    $controller->index();
                }
                break;
            case 'delete':
                if ($id) {
                    $controller->delete((int)$id);
                } else {
                    $controller->index();
                }
                break;
            default:
                $controller->index();
                break;
        }
        break;

    case "admin":
        // Cek login
        Auth::requireLogin();

        if (!Auth::isSuperAdmin()) {
            header('Location: index.php?url=auth&action=unauthorized');
            exit;
        }
        $controller = new App\Controllers\AdminController();

        switch ($action) {
            case 'index':
                $controller->index();
                break;
            case 'create':
                $controller->create();
                break;
            case 'store':
                $controller->store();
                break;
            case 'edit':
                if ($id) {
                    $controller->edit((int)$id);
                } else {
                    $controller->index();
                }
                break;
            case 'delete':
                if ($id) {
                    $controller->delete((int)$id);
                } else {
                    $controller->index();
                }
                break;
            default:
                $controller->index();
                exit;
                break;
        }
        break;

    default:
        http_response_code(404);
        echo "404 - Halaman tidak ditemukan";
        break;
}
