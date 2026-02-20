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

    public function findByUsernameOrEmail(string $identifier): array|false
    {
        $stmt = $this->db->prepare("
            SELECT * FROM users 
            WHERE username = :identifier OR email = :identifier
            LIMIT 1
        ");
        $stmt->execute(['identifier' => $identifier]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function create(array $data): bool
    {
        try {
            $query = "INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)";
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => password_hash($data['password'], PASSWORD_DEFAULT),
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
}
