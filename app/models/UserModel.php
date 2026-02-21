<?php

namespace App\models;

use Core\Database;
use PDO;
use PDOException;

class UserModel
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

    public function findByUsernameOrEmail(string $identifier): ?array
    {
        try {
            $stmt = $this->db->prepare("
            SELECT * FROM users 
            WHERE username = :identifier OR email = :identifier
            LIMIT 1
            ");
            $stmt->execute(['identifier' => $identifier]);
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);

            return $result ?: null;
        } catch (PDOException $e) {
            error_log('Error findByUsernameOrEmail ' . $e->getMessage());
            return null;
        }
    }

    public function create(array $data): bool
    {
        try {
            $query = "INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)";
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => $data['password'],
                'role' => $data['role'] ?? 'user'
            ]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log('Error User create ' . $e->getMessage());
            return false;
        }
    }

    public function update(int $id, array $data): bool
    {
        try {
            $query = "UPDATE users SET username = :username, email = :email, role = :role WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                'id' => $id,
                'username' => $data['username'],
                'email' => $data['email'],
                'role' => $data['role']
            ]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Error User update " . $e->getMessage());
            return false;
        }
    }

    public function updatePassword(int $id, string $password): bool
    {
        try {
            $query = "UPDATE users SET password = :password WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                'id' => $id,
                'password' => password_hash($password, PASSWORD_DEFAULT)
            ]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Error User update " . $e->getMessage());
            return false;
        }
    }

    public function delete(int $id): bool
    {
        try {
            $query = "DELETE FROM users WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Error User delete " . $e->getMessage());
            return false;
        }
    }

    public function getAllAdmins(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE role = 'admin' ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByUsername(string $username): ?array
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
            $stmt->execute(['username' => $username]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result ?: null;
        } catch (PDOException $e) {
            error_log('Error findByUsername: ' . $e->getMessage());
            return null;
        }
    }

    public function findByEmail(string $email): ?array
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
            $stmt->execute(['email' => $email]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result ?: null;
        } catch (PDOException $e) {
            error_log('Error findByEmail: ' . $e->getMessage());
            return null;
        }
    }
}
