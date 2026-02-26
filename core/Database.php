<?php

namespace Core;

use PDO;
use PDOException;

class Database
{
    private string $host = DB_HOST;
    private string $dbName = DB_NAME;
    private string $username = DB_NAME;
    private ?PDO $pdo = null;

    private static ?Database $instance = null;

    public function __construct()
    {
        $this->validateConfig();
        $this->connect();
    }

    public static function getInstance(): Database
    {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    private function __clone() {}

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize singelton");
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
            $errors[] = "Database tidak boleh kosong";
        }

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
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
            $this->pdo = new PDO($dsn, DB_USER, DB_PASS);
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

    public function testConnection(): bool
    {
        try {
            $this->getConnection()->query('SELECT 1');
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}
