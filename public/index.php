<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../utils/helpers.php';


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


$url = $_GET['url'] ?? 'auth';
$action = $_GET['action'] ?? 'login';
$id = $_GET['id'] ?? null;


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
        session_start();
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: index.php?url=auth&action=login');
            exit;
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

    default:
        http_response_code(404);
        echo "404 - Halaman tidak ditemukan";
        break;
}
