<?php

namespace App\Controllers;

use App\Models\UserModel;
use Core\Controller;
use Core\Auth;

class AuthController extends Controller
{
    private UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel;
    }

    /**
     * Tampilkan form login
     */
    public function login(): void
    {
        // Jika sudah login, redirect ke dashboard
        if (Auth::check()) {
            header('Location: index.php?url=karyawan');
            exit;
        }

        $this->view('auth/login', [
            'judul' => 'Login Admin'
        ]);
    }

    /**
     * Proses login
     */
    public function authenticate(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?url=auth&action=login');
            exit;
        }

        $errors = [];
        $identifier = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        // Validasi
        if (empty($identifier)) {
            $errors[] = 'Username atau email harus diisi';
        }

        if (empty($password)) {
            $errors[] = 'Password harus diisi';
        }

        if (empty($errors)) {
            // Cari user
            $user = $this->userModel->findByUsernameOrEmail($identifier);

            if ($user && password_verify($password, $user['password'])) {
                // Login berhasil
                Auth::login($user);

                // Redirect berdasarkan role
                if ($user['role'] === 'admin') {
                    header('Location: index.php?url=karyawan');
                } else {
                    header('Location: index.php?url=dashboard');
                }
                exit;
            } else {
                $errors[] = 'Username/email atau password salah';
            }
        }

        // Jika ada error, tampilkan form kembali
        $this->view('auth/login', [
            'judul' => 'Login Admin',
            'errors' => $errors,
            'old' => ['username' => $identifier]
        ]);
    }

    /**
     * Logout
     */
    public function logout(): void
    {
        Auth::logout();
        header('Location: index.php?url=auth&action=login');
        exit;
    }

    /**
     * Halaman unauthorized
     */
    public function unauthorized(): void
    {
        $this->view('auth/unauthorized', [
            'judul' => 'Akses Ditolak'
        ]);
    }

    /**
     * Dashboard user biasa
     */
    public function dashboard(): void
    {
        Auth::requireLogin();

        $this->view('auth/dashboard', [
            'judul' => 'Dashboard User',
            'user' => Auth::user()
        ]);
    }
}
