<?php

namespace Core;

use PDO;
use PDOException;

class Database
{
    private string $host;
    private string $dbName;
    private string $username;
    private string $password;
    private ?PDO $pdo = null;

    public function __construct()
    {
        $this->loadEnv();
        $this->validateConfig();
        $this->connect();
    }

    private function loadEnv(): void
    {
        // ! Default Value
        $this->host = 'localhost';
        $this->dbName = 'db_karyawan';
        $this->username = 'root';
        $this->password = '';

        $envFile = __DIR__ . '/../.env';
        if (file_exists($envFile)) {
            $env = parse_ini_file($envFile);
            $this->host = $env['DB_HOST'] ?? $this->host;
            $this->dbName = $env['DB_NAME'] ?? $this->dbName;
            $this->username = $env['DB_USER'] ?? $this->username;
            $this->password = $env['DB_PASSWORD'] ?? $this->password;
        }
    }

    private function validateConfig(): void
    {
        $errors = [];
        if (empty($this->host)) {
            $errors[] = "Host tidak boleh kosong";
        }

        if (empty($this->username)) {
            $errors[] = "Usernama tidak boleh kosong";
        }

        if (empty($this->dbName)) {
            $errors[] = "Database tidal boleh kosong";
        }

        // ! Validasi tambahan
        if (!empty($this->host) && !preg_match('/^[a-zA-Z0-9\.\-]+$/', $this->host)) {
            $errors[] = "Format tidak valid";
        }

        if (!empty($errors)) {
            throw new PDOException(implode(",", $errors));
        }
    }

    private function connect(): void
    {
        try {
            $dsn = "mysql:host=$this->host;
            dbname=$this->dbName;charset=utf8mb4";
            $this->pdo = new PDO($dsn, $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database koneksi error" . $e->getMessage());
            throw new PDOException("Gagal konek ke database");
        }
    }

    public function getConnection(): PDO
    {
        if ($this->pdo === null) {
            $this->connect();
        }
        return $this->pdo;
    }
}
