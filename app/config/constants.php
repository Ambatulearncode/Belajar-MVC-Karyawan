<?php

$envFile = __DIR__ . '/../../.env';
$env = file_exists($envFile) ? parse_ini_file($envFile) : [];

// ? Define all Constants
define('BASE_URL', $env['BASE_URL'] ?? 'http://localhost/belajar-mvc-karyawan');
define('DB_HOST', $env['DB_HOST'] ?? 'localhost');
define('DB_NAME', $env['DB_NAME'] ?? 'db_karyawan');
define('DB_USER', $env['DB_USER'] ?? 'root');
define('DB_PASS', $env['DB_PASSWORD'] ?? '');
