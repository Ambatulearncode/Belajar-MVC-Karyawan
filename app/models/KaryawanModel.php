<?php

namespace App\Models;

use Core\Database;
use PDO;

class KaryawanModel
{
    private PDO $db;

    public function __construct()
    {
        $this->connectDb();
    }

    private function connectDb(): void
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getAllKaryawan(): array
    {
        $query = "SELECT * FROM karyawan ORDER BY id DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getKaryawanById(int $id): ?array
    {
        $query = "SELECT * FROM karyawan WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(array $data): bool
    {
        $query = "INSERT INTO karyawan (nama, jabatan, gaji, tanggal_masuk) VALUES (:nama, :jabatan, :gaji, :tanggal_masuk)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nama', $data['nama']);
        $stmt->bindParam(':jabatan', $data['jabatan']);
        $stmt->bindParam(':gaji', $data['gaji']);
        $stmt->bindParam(':tanggal_masuk', $data['tanggal_masuk']);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function update(int $id, array $data): bool
    {
        $query = "UPDATE karyawan SET nama = :nama, jabatan = :jabatan, gaji = :gaji, tanggal_masuk = :tanggal_masuk WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nama', $data['nama']);
        $stmt->bindParam(':jabatan', $data['jabatan']);
        $stmt->bindParam(':gaji', $data['gaji']);
        $stmt->bindParam(':tanggal_masuk', $data['tanggal_masuk']);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->rowCount() > 0;
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
