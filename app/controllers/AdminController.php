<?php

namespace App\controllers;

use App\Models\UserModel;
use Core\Controller;
use Core\Auth;

class AdminController extends Controller
{
    private UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel;
    }

    public function index(): void
    {
        $admins = $this->userModel->getAllAdmins();

        $this->view('admin/index', [
            'judul' => 'Daftar Admin',
            'admins' => $admins
        ]);
    }

    public function create(): void
    {
        $this->view('admin/create', [
            'judul' => 'Tambah Admin Baru'
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

        if (empty($username)) {
            $errors[] = 'Username harus di isi';
        } elseif (strlen($username < 3)) {
            $errors[] = 'Username minimal 3 karakter';
        } elseif ($this->userModel->findByUsernameOrEmail($username)) {
            $errors[] = 'Username sudah di gunakan';
        }

        if (empty($email)) {
            $errors[] = 'Email harus di isi';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Format email tidak valid';
        } elseif ($this->userModel->findByUsernameOrEmail($email)) {
            $errors[] = 'Email sudah terdaftar';
        }

        if (empty($password)) {
            $errors[] = 'Password harus di isi';
        } elseif (strlen($password) < 6) {
            $errors[] = 'Password minimal 6 karakter';
        } elseif ($password !== $password_confirmation) {
            $errors[] = 'Password tidak sama';
        }

        if (empty($errors)) {
            $data = [
                'username' => $username,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'role' => 'admin'
            ];

            if ($this->userModel->create($data)) {
                $_SESSION['success'] = 'Admin baru berhasil ditambahkan';
                header('Location: index.php?url=karyawan');
                exit;
            } else {
                $errors[] = 'Gagal menambahkan admin, Silahkan coba lagi.';
            }
        }

        $this->view('admin/create', [
            'judul' => 'Tambahkan Admin Baru',
            'errors' => $errors,
            'old' => $old
        ]);
    }
}
