<?php

use App\Models\ActivityLogModel;


function log_activity(string $action, string $description): void
{
    if (!isset($_SESSION['user'])) {
        return;
    }

    $userId = $_SESSION['user']['id'] ?? 0;
    $ipAddress = $_SERVER['REMOTE_ADDR'] ?? null;
    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? null;

    $logModel = new ActivityLogModel();
    $logModel->log($userId, $action, $description, $ipAddress, $userAgent);
}

function get_activity_icon(string $action): string
{
    $icons = [
        'login' => 'bi-box-arrow-in-right',
        'logout' => 'bi-box-arrow-right',
        'create' => 'bi-plus-circle',
        'update' => 'bi-pencil',
        'delete' => 'bi-trash',
        'soft_delete' => 'bi-archive',
        'restore' => 'bi-arrow-return-left',
        'view' => 'bi-eye',
        'export' => 'bi-download',
        'import' => 'bi-upload',
        'system' => 'bi-gear',
        'error' => 'bi-exclamation-triangle',
        'warning' => 'bi-exclamation-circle',
        'info' => 'bi-info-circle',
        'success' => 'bi-check-circle'
    ];

    return $icons[$action] ?? 'bi-activity';
}

function get_activity_color(string $action): string
{
    $colors = [
        'login' => 'text-green-600 bg-green-100',
        'logout' => 'text-red-600 bg-red-100',
        'create' => 'text-blue-600 bg-blue-100',
        'update' => 'text-yellow-600 bg-yellow-100',
        'delete' => 'text-red-600 bg-red-100',
        'soft_delete' => 'text-orange-600 bg-orange-100',
        'restore' => 'text-teal-600 bg-teal-100',
        'view' => 'text-purple-600 bg-purple-100',
        'export' => 'text-indigo-600 bg-indigo-100',
        'import' => 'text-pink-600 bg-pink-100',
        'system' => 'text-gray-600 bg-gray-100',
        'error' => 'text-red-600 bg-red-100',
        'warning' => 'text-orange-600 bg-orange-100',
        'info' => 'text-blue-600 bg-blue-100',
        'success' => 'text-green-600 bg-green-100'
    ];

    return $colors[$action] ?? 'text-gray-600 bg-gray-100';
}
