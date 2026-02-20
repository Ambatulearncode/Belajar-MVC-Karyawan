<?php

/**
 * Get base URL dari project
 */
function base_url(string $path = ''): string
{
    // Deteksi protocol
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';

    // Get host
    $host = $_SERVER['HTTP_HOST'];

    // Get script directory (folder tempat index.php berada)
    $scriptDir = dirname($_SERVER['SCRIPT_NAME']);

    // Build base URL
    $base = $protocol . '://' . $host . $scriptDir;

    // Remove trailing slash
    $base = rtrim($base, '/');

    // Add path if provided
    if ($path) {
        $base .= '/' . ltrim($path, '/');
    }

    return $base;
}

/**
 * Generate full URL untuk aplikasi
 */
function url(string $path = ''): string
{
    return base_url($path);
}

/**
 * Redirect dengan base URL
 */
function redirect_to(string $path): void
{
    header('Location: ' . url($path));
    exit;
}
