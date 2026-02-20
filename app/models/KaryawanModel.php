<?php

namespace App\Models;

use Core\Database;
use PDO;
use PDOException;
<<<<<<< HEAD
use PDORow;
=======
>>>>>>> 2aec3b66a430d3c073b7b48dc32787f00ba4d2ed

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
<<<<<<< HEAD
        } catch (\Exception $e) {
            die("Gagal konek ke database" . $e->getMessage());
=======
        } catch (PDOException $e) {
            die("Gagal konek ke database: " . $e->getMessage());
>>>>>>> 2aec3b66a430d3c073b7b48dc32787f00ba4d2ed
        }
    }

    public function getAllKaryawan(): array
    {
        try {
<<<<<<< HEAD
            $query = "SELECT * FROM karyawan";
=======
            $query = "SELECT * FROM karyawan ORDER BY id DESC";
>>>>>>> 2aec3b66a430d3c073b7b48dc32787f00ba4d2ed
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
<<<<<<< HEAD
            error_log("Error getAllKaryawan" . $e->getMessage());
=======
            error_log("Error getAllKaryawan " . $e->getMessage());
>>>>>>> 2aec3b66a430d3c073b7b48dc32787f00ba4d2ed
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
<<<<<<< HEAD
        } catch (PDOException $e) {
            error_log("Error getKaryawanById" . $e->getMessage());
=======
        } catch(PDOException $e){
            error_log("Error getKaryawanById " . $e->getMessage());
>>>>>>> 2aec3b66a430d3c073b7b48dc32787f00ba4d2ed
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
<<<<<<< HEAD
        } catch (\PDOException $e) {
            error_log("Error create karyawan: " . $e->getMessage());
=======
        } catch(PDOException $e){
            error_log("Error create " . $e->getMessage());
>>>>>>> 2aec3b66a430d3c073b7b48dc32787f00ba4d2ed
            return false;
        }
    }

    public function update(int $id, array $data): bool
    {
        try {
<<<<<<< HEAD
            $query = "UPDATE karyawan SET 
                nama = :nama, 
                jabatan = :jabatan, 
                gaji = :gaji, 
                tanggal_masuk = :tanggal_masuk 
            WHERE id = :id";

            $stmt = $this->db->prepare($query);

=======
            $query = "UPDATE karyawan SET nama = :nama, jabatan = :jabatan, gaji = :gaji, tanggal_masuk = :tanggal_masuk WHERE id = :id";
            $stmt = $this->db->prepare($query);
>>>>>>> 2aec3b66a430d3c073b7b48dc32787f00ba4d2ed
            $stmt->bindParam(':nama', $data['nama']);
            $stmt->bindParam(':jabatan', $data['jabatan']);
            $stmt->bindParam(':gaji', $data['gaji']);
            $stmt->bindParam(':tanggal_masuk', $data['tanggal_masuk']);
            $stmt->bindParam(':id', $id);
<<<<<<< HEAD

            $stmt->execute();

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
=======
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (PDOException $e){
>>>>>>> 2aec3b66a430d3c073b7b48dc32787f00ba4d2ed
            error_log("Error update" . $e->getMessage());
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
        } catch(PDOException $e){
            error_log("Error delete " . $e->getMessage());
            return false;
        }
    }
}
