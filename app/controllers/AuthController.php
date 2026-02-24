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
            $this->redirectBasedOnRole();
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

                // Log activity
                log_activity('login', 'User : ' . $_SESSION['user']['username'] . ' login');;

                // Redirect berdasarkan role
                $this->redirectBasedOnRole();
                exit;
            } else {
                $errors[] = 'Username/email atau password salah';

                log_activity('error', 'Percobaan login gagal untuk: ' . $identifier);
            }
        }

        if (!empty($errors)) {
            $_SESSION['error'] = implode(', ', $errors);
            $_SESSION['old'] = ['username' => $identifier];
        }
        header('Location: index.php?url=auth&action=login');
    }

    private function redirectBasedOnRole(): void
    {
        if (!Auth::check()) {
            header('Location: index.php?url=auth&action=login');
            exit;
        }

        $user = Auth::user();

        if ($user['role'] === 'superadmin' || $user['role'] === 'admin') {
            header('Location: index.php?url=karyawan');
            exit;
        } else {
            header('Location: index.php?url=auth&action=dashboard');
            exit;
        }
    }

    /**
     * Logout
     */
    public function logout(): void
    {
        if (isset($_SESSION['user'])) {
            log_activity('logout', 'User : ' . $_SESSION['user']['username'] . ' logout');
        }

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

        if (Auth::isAdmin()) {
            header('Location: index.php?url=karyawan');
            exit;
        }

        $this->view('auth/dashboard', [
            'judul' => 'Dashboard User',
            'user' => Auth::user()
        ]);
    }
}
