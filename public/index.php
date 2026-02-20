<?php

require_once __DIR__ . '/../vendor/autoload.php';

// Include helper
require_once __DIR__ . '/../utils/helpers.php';

// Simple routing
$url = $_GET['url'] ?? 'karyawan';
$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? null;

// Debug: Tampilkan parameter
// echo "URL: $url, Action: $action, ID: $id<br>";

switch ($url) {
    case "karyawan":
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
