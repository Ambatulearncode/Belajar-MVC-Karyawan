<?php

namespace App\Models;

use Core\Database;
use PDO;
use PDOException;
use PDORow;

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
            $database = new Database();
            $this->db = $database->getConnection();
        } catch (\Exception $e) {
            die("Gagal konek ke database" . $e->getMessage());
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
            error_log("Error getAllKaryawan" . $e->getMessage());
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
            error_log("Error getKaryawanById" . $e->getMessage());
            return null;
        }
    }

    public function create(array $data): bool
    {
        try {
            $query = "INSERT INTO karyawan (nama, jabatan, gaji, tanggal_masuk) VALUES (:nama, :jabatan, :gaji, :tanggal_masuk)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':nama', $data['nama']);
            $stmt->bindParam(':jabatan', $data['jabatan']);
            $stmt->bindParam(':gaji', $data['gaji']);
            $stmt->bindParam(':tanggal_masuk', $data['tanggal_masuk']);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (\PDOException $e) {
            error_log("Error create karyawan: " . $e->getMessage());
            return false;
        }
    }

    public function update(int $id, array $data): bool
    {
        try {
            $query = "UPDATE karyawan SET 
                nama = :nama, 
                jabatan = :jabatan, 
                gaji = :gaji, 
                tanggal_masuk = :tanggal_masuk 
            WHERE id = :id";

            $stmt = $this->db->prepare($query);

            $stmt->bindParam(':nama', $data['nama']);
            $stmt->bindParam(':jabatan', $data['jabatan']);
            $stmt->bindParam(':gaji', $data['gaji']);
            $stmt->bindParam(':tanggal_masuk', $data['tanggal_masuk']);
            $stmt->bindParam(':id', $id);

            $stmt->execute();

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Error update" . $e->getMessage());
            return false;
        }
    }

    public function delete(int $id): bool
    {
        $query = "DELETE FROM karyawan WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }
}
