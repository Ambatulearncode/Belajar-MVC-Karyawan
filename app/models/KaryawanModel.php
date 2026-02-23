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

    public function getAllKaryawan(): array
    {
        try {
            $query = "SELECT * FROM karyawan";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getAllKaryawan " . $e->getMessage());
            return [];
        }
    }

    public function getKaryawanById(int $id): ?array
    {
        try {
            $query = "SELECT * FROM karyawan WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getKaryawanById " . $e->getMessage());
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

    public function getTotalCount(): int
    {
        try {
            $query = "SELECT COUNT(*) as total FROM karyawan";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return (int) ($result['total'] ?? 0);
        } catch (PDOException $e) {
            error_log("Error getTotalCount " . $e->getMessage());
            return 0;
        }
    }

    public function getTotalSalary(): float
    {
        try {
            $query = "SELECT SUM(gaji) as total_gaji FROM karyawan";
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
            $query = "SELECT AVG(gaji) as avg_gaji FROM karyawan";
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
