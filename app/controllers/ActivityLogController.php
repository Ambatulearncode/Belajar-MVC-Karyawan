<?php

namespace App\Controllers;

use App\models\ActivityLogModel;
use Core\Controller;
use Core\Auth;


class ActivityLogController extends Controller
{
    private ActivityLogModel $activityLogModel;

    public function __construct()
    {
        if (!Auth::isSuperAdmin()) {
            header('Location: index.php?url=auth&action=unauthorized');
            exit;
        }
        $this->activityLogModel = new ActivityLogModel();
    }

    public function index(): void
    {
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 20;

        if ($currentPage < 1) {
            $currentPage = 1;
        }

        $logs = $this->activityLogModel->getPaginated($currentPage, $perPage);
        $totalItems  = $this->activityLogModel->getTotalCount();
        $totalPages = ceil($totalItems / $perPage);
        $recentActivities = $this->activityLogModel->getRecent(5);
        $statistics = $this->activityLogModel->getStatistics();
        $todayCount = $this->activityLogModel->getTodayCount();
        $activeUserCount = $this->activityLogModel->getActiveUsersCount();

        $data = [
            'judul' => 'Activity Log',
            'logs' => $logs,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'totalItems' => $totalItems,
            'perPage' => $perPage,
            'recentActivities' => $recentActivities,
            'statistics' => $statistics,
            'todayCount' => $todayCount,
            'activeUserCount' => $activeUserCount
        ];

        $this->view('activity-log/index', $data);
    }

    public function clear(): void
    {
        $days = $_GET['days'] ?? 30;

        if ($this->activityLogModel->clearOldLogs($days)) {
            $_SESSION['success'] = "Log aktivitas lebih dari $days hari berhasil dibersihkan!";

            log_activity('system', 'Membersihkan log aktivitas lebih dari $days hari');
        } else {
            $_SESSION['error'] = 'Gagal membersihkan log.';
        }

        header('Location: index.php?url=activity-log');
        exit;
    }
}
