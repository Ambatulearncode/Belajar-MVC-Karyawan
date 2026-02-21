<?php

namespace App\Controllers;  // Perbaiki namespace (pake 'Controllers' huruf besar)

use App\Models\UserModel;
use Core\Controller;
use Core\Auth;

class AdminController extends Controller
{
    private UserModel $userModel;

    public function __construct()
    {
        Auth::requireLogin();


        if (!Auth::isSuperAdmin()) {
            $_SESSION['error'] = 'Akses ditolak! Hanya Super Admin yang bisa mengelola admin.';
            header('Location: index.php?url=auth&action=unauthorized');
            exit;
        }

        $this->userModel = new UserModel;
    }

    public function index(): void
    {
        $admins = $this->userModel->getAllAdmins();

        $this->view('admin/index', [
            'judul' => 'Daftar Admin',
            'admins' => $admins,
            'user' => Auth::user()
        ]);
    }

    public function create(): void
    {
        $this->view('admin/create', [
            'judul' => 'Tambah Admin Baru',
            'user' => Auth::user()
        ]);
    }

    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?url=admin&action=create');
            exit;
        }

        $errors = [];
        $old = $_POST;

        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $password_confirmation = $_POST['password_confirmation'] ?? '';

        // Validasi Username
        if (empty($username)) {
            $errors[] = 'Username harus diisi';
        } elseif (strlen($username) < 3) {
            $errors[] = 'Username minimal 3 karakter';
        } elseif ($this->userModel->findByUsername($username)) {
            $errors[] = 'Username sudah digunakan';
        }

        // Validasi Email
        if (empty($email)) {
            $errors[] = 'Email harus diisi';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Format email tidak valid';
        } elseif ($this->userModel->findByEmail($email)) {
            $errors[] = 'Email sudah terdaftar';
        }

        // Validasi Password
        if (empty($password)) {
            $errors[] = 'Password harus diisi';
        } elseif (strlen($password) < 6) {
            $errors[] = 'Password minimal 6 karakter';
        } elseif ($password !== $password_confirmation) {
            $errors[] = 'Konfirmasi password tidak cocok';
        }

        // Kalo ga ada error, simpan
        if (empty($errors)) {
            $data = [
                'username' => $username,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'role' => 'admin'
            ];

            if ($this->userModel->create($data)) {
                $_SESSION['success'] = 'Admin baru berhasil ditambahkan!';

                error_log("Super Admin " . Auth::user()['username'] . " menambahkan admin baru: $username");

                header('Location: index.php?url=admin&action=index'); // Ke daftar admin, bukan karyawan
                exit;
            } else {
                $errors[] = 'Gagal menambahkan admin. Silakan coba lagi.';
            }
        }

        // Kalo ada error, tampilkan form lagi
        $this->view('admin/create', [
            'judul' => 'Tambah Admin Baru',
            'errors' => $errors,
            'old' => $old,
            'user' => Auth::user()
        ]);
    }

    public function edit(int $id): void
    {
        try {
            $admins = $this->userModel->getUserById($id);

            if (!$admins) {
                $_SESSION['error'] = 'Data user tidak ditemukan';
                header('Location: index.php?url=admin');
                exit;
            }

            $this->view('admin/edit', [
                'admin' => $admins,
                'judul' => 'Edit Admins'
            ]);
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Gagal mengambil data: ' . $e->getMessage();
            header('Location: index.php?url=admin');
            exit;
        }
    }

    public function delete(int $id): void
    {
        try {
            $this->userModel->delete($id);
            $_SESSION['success'] = 'Data Admin berhasil di hapus!';
            header('Location: index.php?url=admin');
            exit;
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Gagal menghapus data: ' . $e->getMessage();
            header('Location: index.php?url=admin');
            exit;
        }
    }
}
