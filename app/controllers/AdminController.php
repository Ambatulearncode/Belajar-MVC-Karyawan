<?php

namespace App\Controllers;  // Perbaiki namespace (pake 'Controllers' huruf besar)

use App\Models\UserModel;
use Core\Controller;
use Core\Auth;
use PDOException;

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
            if (!Auth::isSuperAdmin()) {
                header('Location: index.php?url=auth&action=unauthorized');
                exit;
            }

            $id = $_GET['id'] ?? 0;

            if (!$id) {
                $_SESSION['error'] = 'ID admin tidak valid!';
                header('Location: index.php?url=admin');
                exit;
            }

            $admin = $this->userModel->getUserById($id);

            if (!$admin) {
                $_SESSION['error'] = 'Admin tidak ditemukan!';
                header('Location: index.php?url=admin');
                exit;
            }

            $data = [
                'judul' => 'Edit Admin',
                'admin' => $admin
            ];

            $this->view('admin/edit', $data);
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

    public function update(int $id): void
    {
        if (!Auth::isSuperAdmin()) {
            header('Location: index.php?url=auth&action=unauthorized');
            exit;
        }

        $admin = $this->userModel->getUserById($id);

        if ($admin['username'] === 'admin' && $admin['role'] === 'superadmin') {
            $_SESSION['error'] = 'Superadmin tidak dapat diedit!';
            header('Location: index.php?url=admin');
            exit;
        }

        $errors = [];

        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $role = trim($_POST['role'] ?? 'admin');
        $password = $_POST['password'] ?? '';
        $password_confirmation = $_POST['password_confirmation'] ?? '';

        $existingUser = $this->userModel->findByUsername($username);
        if ($existingUser && $existingUser['id'] != $id) {
            $errors['username'] = 'Username sudah digunakan!';
        }

        $existingEmail = $this->userModel->findByEmail($email);
        if ($existingEmail && $existingEmail['id'] != $id) {
            $errors['email'] = 'Email sudah digunakan!';
        }

        if (!empty($password)) {
            if (strlen($password) < 6) {
                $errors['password'] = 'Password minimal 6 karakter!';
            }

            if ($password !== $password_confirmation) {
                $errors['password_confirmation'] = 'Password tidak cocok!';
            }
        }

        if (empty($username)) {
            $errors['username'] = 'Username harus diisi!';
        }

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email tidak valid!';
        }

        $allowedRoles = ['admin', 'user'];
        if (!in_array($role, $allowedRoles)) {
            $errors['role'] = 'Role tidak valid!';
        }

        // If there are errors, redirect back with errors
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = [
                'username' => $username,
                'email' => $email,
                'role' => $role
            ];
            header('Location: index.php?url=admin&action=edit&id=' . $id);
            exit;
        }

        $updatedData = [
            'username' => $username,
            'email' => $email,
            'role' => $role
        ];

        $success = false;
        if (!empty($password)) {
            $success = $this->userModel->updatePassword($id, $password);
            if ($success) {
                $success = $this->userModel->update($id, $updatedData);
            }
        } else {
            $success = $this->userModel->update($id, $updatedData);
        }

        if ($success) {
            $_SESSION['success'] = 'Data admin berhasil diperbarui!';
            header('Location: index.php?url=admin');
            exit;
        } else {
            $_SESSION['error'] = 'Gagal memperbarui data admin!';
            header('Location: index.php?url=admin');
            exit;
        }
    }
}
