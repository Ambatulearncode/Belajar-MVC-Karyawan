<?php

/**
 * Simple script untuk create admin user
 */

use Core\Database;
// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "=== CREATE ADMIN USER SCRIPT ===\n\n";

try {
    // Load dependencies
    require_once __DIR__ . '/vendor/autoload.php';
    require_once __DIR__ . '/core/Database.php';



    $db = Database::getInstance()->getConnection();
    echo "✅ Connected to database\n";

    // Cek/Create table
    $tableCheck = $db->query("SHOW TABLES LIKE 'users'");
    if ($tableCheck->rowCount() == 0) {
        echo "Creating users table...\n";

        $createTable = "CREATE TABLE users (
            id INT PRIMARY KEY AUTO_INCREMENT,
            username VARCHAR(50) UNIQUE NOT NULL,
            email VARCHAR(100) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL,
            role ENUM('admin', 'user') DEFAULT 'user',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

        $db->exec($createTable);
        echo "✅ Table created\n";
    }

    // Generate password hash
    $password = 'admin123';
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    echo "\nPassword: $password\n";
    echo "Hashed: $hashedPassword\n";

    // Cek admin
    $stmt = $db->prepare("SELECT * FROM users WHERE username = 'admin'");
    $stmt->execute();
    $admin = $stmt->fetch();

    if ($admin) {
        echo "\n✅ Admin found. Updating password...\n";

        $sql = "UPDATE users SET password = :password WHERE username = 'admin'";
        $stmt = $db->prepare($sql);
        $stmt->execute(['password' => $hashedPassword]);

        echo "✅ Password updated\n";
    } else {
        echo "\n⚠️ Admin not found. Creating...\n";

        $sql = "INSERT INTO users (username, email, password, role) 
                VALUES (:username, :email, :password, :role)";

        $stmt = $db->prepare($sql);
        $stmt->execute([
            'username' => 'admin',
            'email' => 'admin@karyawan.com',
            'password' => $hashedPassword,
            'role' => 'admin'
        ]);

        echo "✅ Admin created\n";
    }

    // Show all users
    echo "\n=== ALL USERS ===\n";
    $stmt = $db->query("SELECT id, username, email, role FROM users");
    $users = $stmt->fetchAll();

    foreach ($users as $user) {
        echo "ID: {$user['id']} | User: {$user['username']} | Email: {$user['email']} | Role: {$user['role']}\n";
    }

    echo "\n✅ DONE!\n";
    echo "Login with:\n";
    echo "Username: admin\n";
    echo "Password: admin123\n";
    echo "URL: http://localhost/belajar-mvc-karyawan/public/\n";
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
}
