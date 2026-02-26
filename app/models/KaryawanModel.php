<?php

namespace App\Models;

use Core\Database;
use PDO;
use PDOException;

class KaryawanModel
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

    public function getAllActive($search = '', $jabatan = '', $page = 1)
    {
        try {
            $limit = 10;
            $offset = ($page - 1) * $limit;

            // ? Base Query
            $baseQuery = "FROM karyawan WHERE deleted_at IS NULL";
            $params = [];

            // ? Search
            if (!empty($search)) {
                $baseQuery .= " AND (nama LIKE :search OR nik LIKE :search)";
                $params[':search'] = "%$search%";
            }

            // ? Filter jabatan
            if (!empty($jabatan)) {
                $baseQuery .= " AND jabatan = :jabatan";
                $params[':jabatan'] = $jabatan;
            }

            $countSql = "SELECT COUNT(*) as total " . $baseQuery;
            $stmt = $this->db->prepare($countSql);
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            $stmt->execute();
            $totalItems = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

            $dataSql = "SELECT * " . $baseQuery . " ORDER BY nama ASC LIMIT :limit OFFSET :offset";
            $stmt = $this->db->prepare($dataSql);

            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();

            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return [
                'data' => $data,
                'total' => $totalItems,
                'pages' => ceil($totalItems / $limit)
            ];
        } catch (PDOException $e) {
            error_log('Error getAll: ' . $e->getMessage());
            return [
                'data' => [],
                'total' => 0,
                'pages' => 1
            ];
        }
    }

    public function softDelete($id, $deletedBy)
    {
        try {
            error_log("=== SOFT DELETE CALLED ===");
            error_log("ID: " . $id);
            error_log("Deleted By: " . $deletedBy);
            $karyawan = $this->getKaryawanByIdIncludeDeleted($id);

            if (!$karyawan || $karyawan['deleted_at'] !== null) {
                error_log("karyawan tidak ditemukan");
                return false;
            }

            $query = "UPDATE karyawan SET deleted_at = NOW(),deleted_by = :deleted_by WHERE id = :id AND deleted_at IS NULL";
            error_log("Query: " . $query);

            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->bindValue(':deleted_by', $deletedBy, PDO::PARAM_INT);
            $result = $stmt->execute();

            error_log("Row count: " . $stmt->rowCount());
            error_log("Result: " . ($result ? 'true' : 'false'));

            return $result;
        } catch (PDOException $e) {
            error_log("softDelete: " . $e->getMessage());
            return false;
        }
    }

    public function getAllDeleted($search = '', $page = 1)
    {
        try {
            $limit = 10;
            $offset = ($page - 1) * $limit;

            $query = "SELECT k.*, u.username as deleted_by_username FROM karyawan k LEFT JOIN users u ON k.deleted_by = u.id WHERE k.deleted_at IS NOT NULL";

            $countQuery = "SELECT COUNT(*) as total FROM karyawan WHERE deleted_at IS NOT NULL";

            $params = [];

            if (!empty($search)) {
                $query .= " AND (k.nama LIKE :search OR k.nik LIKE :search)";
                $countQuery .= " AND (nama LIKE :search OR nik LIKE :search)";
                $params[':search'] = "%$search%";
            }

            $query .= " ORDER BY k.deleted_at DESC LIMIT :limit OFFSET :offset";

            $stmt = $this->db->prepare($countQuery);
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            $stmt->execute();
            $totalItems = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

            $stmt = $this->db->prepare($query);
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }

            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();

            return [
                'data' => $stmt->fetchAll(PDO::FETCH_ASSOC),
                'total' => $totalItems,
                'pages' => ceil($totalItems / $limit)
            ];
        } catch (PDOException $e) {
            error_log('Error getAllDeleted: ' . $e->getMessage());

            return [
                'data' => [],
                'total' => 0,
                'pages' => 1
            ];
        }
    }

    public function restore($id)
    {
        try {
            $query = "SELECT * FROM karyawan WHERE id = :id AND deleted_at IS NOT NULL";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $karyawan = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$karyawan) {
                return false;
            }

            $query = "UPDATE karyawan SET deleted_at = null,deleted_by = null WHERE id = :id";

            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $result = $stmt->execute();

            if ($result) {
                log_activity('restore', "Mengembalikan Karyawan: " . $karyawan['nama']);
            }

            return $result;
        } catch (PDOException $e) {
            error_log("Error restore: " . $e->getMessage());
            return false;
        }
    }

    public function getAllKaryawan(): array
    {
        try {
            $query = "SELECT * FROM karyawan WHERE deleted_at IS NULL";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getAllKaryawan " . $e->getMessage());
            return [];
        }
    }

    public function getKaryawanByIdIncludeDeleted(int $id): ?array
    {
        try {
            $query = "SELECT * FROM karyawan WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (PDOException $e) {
            error_log('Error getKaryawanByIdIncludedDeleted ' . $e->getMessage());
            return null;
        }
    }

    public function getAllJabatan(): array
    {
        try {
            $query = "SELECT DISTINCT jabatan FROM karyawan ORDER BY jabatan";
            $stmt = $this->db->prepare($query);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $jabatans = [];
            foreach ($result as $row) {
                $jabatans[] = $row['jabatan'];
            }
            return $jabatans;
        } catch (PDOException $e) {
            error_log("Error getAllJabatan " . $e->getMessage());
            return [];
        }
    }

    public function getKaryawanById(int $id): ?array
    {
        try {
            $query = "SELECT * FROM karyawan WHERE id = :id AND deleted_at IS NULL";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (PDOException $e) {
            error_log("Error getKaryawanById " . $e->getMessage());
            return null;
        }
    }

    public function getDeletedKaryawanById(int $id): ?array
    {
        try {
            $query = "SELECT * FROM karyawan WHERE id = :id AND deleted_at IS NOT NULL";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (PDOException $e) {
            error_log('Error getDeletedKaryawanById: ' . $e->getMessage());
            return null;
        }
    }

    public function create(array $data): bool
    {
        try {
            $nik = $this->generateNik();
            $query = "INSERT INTO karyawan (nik, nama, jabatan, gaji, tanggal_masuk) VALUES (:nik, :nama, :jabatan, :gaji, :tanggal_masuk)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':nik', $nik);
            $stmt->bindParam(':nama', $data['nama']);
            $stmt->bindParam(':jabatan', $data['jabatan']);
            $stmt->bindParam(':gaji', $data['gaji']);
            $stmt->bindParam(':tanggal_masuk', $data['tanggal_masuk']);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Error create " . $e->getMessage());
            return false;
        }
    }

    public function update(int $id, array $data): bool
    {
        try {
            $query = "UPDATE karyawan 
            SET nama = :nama, 
            jabatan = :jabatan, 
            gaji = :gaji, 
            tanggal_masuk = :tanggal_masuk 
            WHERE id = :id";

            $stmt = $this->db->prepare($query);

            return $stmt->execute([
                ':nama' => $data['nama'],
                ':jabatan' => $data['jabatan'],
                ':gaji' => (float) $data['gaji'], // Cast ke float dulu
                ':tanggal_masuk' => $data['tanggal_masuk'],
                ':id' => $id
            ]);
        } catch (PDOException $e) {
            error_log("Error update: " . $e->getMessage());
            error_log("Data: " . print_r($data, true));
            return false;
        }
    }

    public function delete(int $id): bool
    {
        try {
            $query = "DELETE FROM karyawan WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Error delete " . $e->getMessage());
            return false;
        }
    }

    public function generateNik(): string
    {
        try {
            $tahun = date('Y');
            $bulan = date('m');
            $tanggal = date('d');

            $prefix = $tahun . $bulan . $tanggal;

            $query = "SELECT nik FROM karyawan WHERE nik LIKE :prefix ORDER BY nik DESC LIMIT 1";

            $stmt = $this->db->prepare($query);
            $searchPrefix = $prefix . '%';
            $stmt->bindParam(':prefix', $searchPrefix);
            $stmt->execute();

            $lastNIK = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($lastNIK) {
                $lastNumber = (int)substr($lastNIK['nik'], -6);
                $newNumber = str_pad($lastNumber + 1, 6, '0', STR_PAD_LEFT);
            } else {
                $newNumber = '000001';
            }

            return $prefix . $newNumber;
        } catch (PDOException $e) {
            error_log('Error generateNik ' . $e->getMessage());
            return $tahun . $bulan . date('His');
        }
    }

    public function getPaginated(int $page = 1, int $perPage = 10): array
    {
        try {
            $offset = ($page - 1) * $perPage;
            $query = "SELECT * FROM karyawan ORDER BY id ASC LIMIT :limit OFFSET :offset";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getPaginated " . $e->getMessage());
            return [];
        }
    }

    public function getPaginatedWithFilter(int $page = 1, int $perPage, ?string $search = null, ?string $jabatan = null): array
    {
        try {
            $offset = ($page - 1) * $perPage;

            $query = "SELECT * FROM karyawan WHERE deleted_at IS NULL";
            $params = [];

            if (!empty($search)) {
                $query .= " AND (nama LIKE :search OR nik LIKE :search)";
                $params[':search'] = "%$search%";
            }

            if (!empty($jabatan) && $jabatan !== 'all') {
                $query .= " AND jabatan = :jabatan";
                $params[":jabatan"] = $jabatan;
            }
            $query .= " ORDER BY id DESC LIMIT :limit OFFSET :offset";
            $stmt = $this->db->prepare($query);

            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }

            $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getPaginatedWithFilter " . $e->getMessage());
            return [];
        }
    }

    public function getTotalCount(): int
    {
        try {
            $query = "SELECT COUNT(*) as total FROM karyawan WHERE deleted_at IS NULL";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return (int) ($result['total'] ?? 0);
        } catch (PDOException $e) {
            error_log("Error getTotalCount " . $e->getMessage());
            return 0;
        }
    }

    public function getTotalCountDeleted()
    {
        try {
            $query = "SELECT COUNT(*) as total FROM karyawan WHERE deleted_at IS NOT NULL";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return (int) ($result['total'] ?? 0);
        } catch (PDOException $e) {
            error_log("Error getTotalCountDeleted: " . $e->getMessage());
            return 0;
        }
    }

    public function getTotalCountWithFilter(?string $search = null, ?string $jabatan = null): int
    {
        try {
            $sql = "SELECT COUNT(*) as total FROM karyawan WHERE deleted_at IS NULL";
            $params = [];

            if (!empty($search)) {
                $sql .= " AND (nama LIKE :search OR nik LIKE :search)";
                $params[':search'] = "%$search%";
            }

            if (!empty($jabatan) && $jabatan !== 'all') {
                $sql .= " AND jabatan = :jabatan";
                $params[':jabatan'] = $jabatan;
            }

            $stmt = $this->db->prepare($sql);

            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }

            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return (int) ($result['total'] ?? 0);
        } catch (PDOException $e) {
            error_log("Error getTotalCountWithFilter " . $e->getMessage());
            return 0;
        }
    }

    public function getTotalSalary(): float
    {
        try {
            $query = "SELECT SUM(gaji) as total_gaji FROM karyawan WHERE deleted_by IS NULL";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return (float) ($result['total_gaji'] ?? 0);
        } catch (PDOException $e) {
            error_log('Error getTotalSalary ' . $e->getMessage());
            return 0;
        }
    }

    public function getAverageSalary(): float
    {
        try {
            $query = "SELECT AVG(gaji) as avg_gaji FROM karyawan WHERE deleted_by IS NULL";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return (float) ($result['avg_gaji'] ?? 0);
        } catch (PDOException $e) {
            error_log('Error getAverageSalary ' . $e->getMessage());
            return 0;
        }
    }
}
