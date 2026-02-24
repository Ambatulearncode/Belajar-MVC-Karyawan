<?php

namespace App\Models;

use Core\Database;
use PDO;
use PDOException;


class ActivityLogModel
{
    private PDO $db;

    public function __construct()
    {
        $this->connectDb();
    }

    private function connectDb(): void
    {
        try {
            $database = Database::getInstance();
            $this->db = $database->getConnection();
        } catch (PDOException $e) {
            die("Gagal konek ke database: " . $e->getMessage());
        }
    }

    public function log(int $userId, string $action, string $description, ?string $ipAddress = null, ?string $userAgent = null): bool
    {
        try {
            $query = "INSERT INTO activity_logs (user_id, action, description, ip_address, user_agent) VALUES (:user_id, :action, :description, :ip_address, :user_agent)";

            $stmt = $this->db->prepare($query);
            $stmt->execute(
                [
                    'user_id' => $userId,
                    'action' => $action,
                    'description' => $description,
                    'ip_address' => $ipAddress,
                    'user_agent' => $userAgent
                ]
            );

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Error ActivityLog log: " . $e->getMessage());
            return false;
        }
    }

    public function getPaginated(int $page = 1, int $perPage = 10): array
    {
        try {
            $offset = ($page - 1) * $perPage;
            $query = "SELECT al.*, u.username, u.email, u.role FROM activity_logs al JOIN users u ON al.user_id = u.id ORDER BY al.created_at DESC LIMIT :limit OFFSET :offset";

            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getPaginated: " . $e->getMessage());
            return [];
        }
    }

    public function getTotalCount(): int
    {
        try {
            $query = "SELECT COUNT(*) as total FROM activity_logs";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return (int) ($result['total'] ?? 0);
        } catch (PDOException $e) {
            error_log("Error getTotalCount: " . $e->getMessage());
            return 0;
        }
    }

    public function getByUserId(int $userId, int $limit = 50): array
    {
        try {
            $query = "SELECT * FROM activity_logs WHERE user_id = :user_id ORDER BY created_at DESC LIMIT :limit";

            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error getByUserId: ' . $e->getMessage());
            return [];
        }
    }

    public function getRecent(int $limit = 10): array
    {
        try {
            $query = "SELECT al.*, u.username, u.role FROM activity_logs al JOIN users u ON al.user_id = u.id ORDER BY al.created_at DESC LIMIT :limit";

            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error getRecent: ' . $e->getMessage());
            return [];
        }
    }

    public function clearOldLogs(): bool
    {
        try {
            $query = "DELETE FROM activity_logs WHERE created_at < DATE_SUB(NOW(), INTERVAL 30 DAY)";
            $stmt = $this->db->prepare($query);
            $stmt->execute();

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log('Error clearOldLogs: ' . $e->getMessage());
            return false;
        }
    }

    public function getStatistics(): array
    {
        try {
            $query = "SELECT action,COUNT(*) as total FROM activity_logs WHERE crated_at >= DATE_SUB(NOW(), INTERVAL 30 DAY) GROUP by action";

            $stmt = $this->db->prepare($query);
            $stmt->execute();

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $statistics = [
                'login' => 0,
                'create' => 0,
                'update' => 0,
                'delete' => 0,
                'total' => 0
            ];

            foreach ($results as $row) {
                switch ($row['action']) {
                    case 'login':
                        $statistics['login'] = (int)$row['total'];
                        break;
                    case 'tambah':
                    case 'create':
                        $statistics['create'] = (int)$row['total'];
                        break;
                    case 'edit':
                    case 'update':
                        $statistics['update'] = (int)$row['total'];
                        break;
                    case 'hapus':
                    case 'delete':
                        $statistics['delete'] = (int)$row['total'];
                        break;
                }
                $statistics['total'] += (int)$row['total'];
            }
            return $statistics;
        } catch (PDOException $e) {
            error_log("Error getStatistics: " . $e->getMessage());
            return [
                'login' => 0,
                'create' => 0,
                'update' => 0,
                'delete' => 0,
                'total' => 0
            ];
        }
    }

    public function getStatisticsByPeriods(string $period = '30 DAY'): array
    {
        try {
            $query = "SELECT DATE(created_at) as tanggal,action,COUNT(*) as jumlah FROM activity_logs WHERE created_at >= DATE_SUB(NOW(), INTERVAL $period) GROUP BY DATE(created_at), action ORDER BY tanggal DESC";

            $stmt = $this->db->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error getStatisticsByPeriods: ' . $e->getMessage());
            return [];
        }
    }

    public function getTodayCount(): int
    {
        try {
            $query = "SELECT COUNT(*) as total FROM activity_logs WHERE DATE(created_at) = CURDATE()";

            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return (int)($result['total'] ?? 0);
        } catch (PDOException $e) {
            error_log('Error getTodayCount: ' . $e->getMessage());
            return 0;
        }
    }

    public function getActiveUsersCount(): int
    {
        try {
            $query = "SELECT COUNT (DISTINCT user_id) as total FROM activity_logs WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)";

            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return (int)($result['total'] ?? 0);
        } catch (PDOException $e) {
            error_log('Error getActiveUsersCount: ' . $e->getMessage());
            return 0;
        }
    }
}
