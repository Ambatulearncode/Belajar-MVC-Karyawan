<?php

namespace App\Controllers;

use App\Models\KaryawanModel;
use Core\Controller;
use Core\Auth;

class KaryawanController extends Controller
{
    private KaryawanModel $karyawanModel;

    public function __construct()
    {
        Auth::requireAdmin();
        $this->karyawanModel = new KaryawanModel;
    }

    public function index(): void
    {
        if (!Auth::isAdmin()) {
            header("Location: index.php?url=auth&action=unauthorized");
            exit;
        }

        $search = $_GET['search'] ?? null;
        $jabatan = $_GET['jabatan'] ?? null;

        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 10;

        if ($currentPage < 1) {
            $currentPage = 1;
        }

        $karyawan = $this->karyawanModel->getPaginatedWithFilter($currentPage, $perPage, $search, $jabatan);
        $totalItems = $this->karyawanModel->getTotalCountWithFilter($search, $jabatan);
        $totalPages = ceil($totalItems / $perPage);

        $allJabatans = $this->karyawanModel->getAllJabatan();

        $data = [
            'judul' => 'Daftar Karyawan',
            'karyawan' => $karyawan,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'totalItems' => $totalItems,
            'perPage' => $perPage,
            'karyawanModel' => $this->karyawanModel,
            'search' => $search,
            'selectedJabatan' => $jabatan,
            'allJabatans' => $allJabatans
        ];

        $this->view('karyawan/index', $data);
    }

    public function create(): void
    {
        $this->view('karyawan/create', [
            'judul' => 'Tambah Karyawan'
        ]);
    }

    public function store(): void
    {
        // Validasi method request
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?url=karyawan');
            exit;
        }

        // Inisialisasi errors
        $errors = [];

        // Sanitize input - HAPUS EMAIL
        $nama = trim($_POST['nama'] ?? '');
        $jabatan = trim($_POST['jabatan'] ?? '');
        $gaji = trim($_POST['gaji'] ?? '');
        $tanggal_masuk = trim($_POST['tanggal_masuk'] ?? '');

        // Validasi Nama
        if (empty($nama)) {
            $errors[] = 'Nama harus diisi';
        } elseif (strlen($nama) < 3) {
            $errors[] = 'Nama minimal 3 karakter';
        }

        // Validasi Jabatan
        if (empty($jabatan)) {
            $errors[] = 'Jabatan harus diisi';
        } elseif (strlen($jabatan) < 3) {
            $errors[] = 'Jabatan minimal 3 karakter';
        }

        // Validasi Gaji
        if (empty($gaji)) {
            $errors[] = 'Gaji harus diisi';
        } elseif (!is_numeric($gaji)) {
            $errors[] = 'Gaji harus berupa angka';
        } elseif ($gaji <= 0) {
            $errors[] = 'Gaji harus bernilai positif';
        }

        // Validasi Tanggal Masuk
        if (empty($tanggal_masuk)) {
            $errors[] = 'Tanggal masuk harus diisi';
        } elseif (!strtotime($tanggal_masuk)) {
            $errors[] = 'Format tanggal tidak valid';
        }

        // Jika ada errors, tampilkan form kembali
        if (!empty($errors)) {
            $this->view('karyawan/create', [
                'judul' => 'Tambah Karyawan',
                'errors' => $errors,
                'old' => [
                    'nama' => $nama,
                    'jabatan' => $jabatan,
                    'gaji' => $gaji,
                    'tanggal_masuk' => $tanggal_masuk
                ]
            ]);
            return;
        }

        // Jika validasi sukses, simpan data
        try {
            $data = [
                'nama' => $nama,
                'jabatan' => $jabatan,
                'gaji' => (float) $gaji,
                'tanggal_masuk' => $tanggal_masuk
            ];

            $this->karyawanModel->create($data);
            $_SESSION['success'] = 'Data karyawan berhasil ditambahkan!';
            header('Location: index.php?url=karyawan');
            exit;
        } catch (\Exception $e) {
            // Redirect dengan error message
            $_SESSION['error'] = 'Gagal menyimpan data: ' . $e->getMessage();
            header('Location: index.php?url=karyawan&action=create');
            exit;
        }
    }

    public function edit(int $id): void
    {
        try {
            $karyawan = $this->karyawanModel->getKaryawanById($id);

            if (!$karyawan) {
                $_SESSION['error'] = 'Data karyawan tidak ditemukan!';
                header('Location: index.php?url=karyawan');
                exit;
            }

            $this->view('karyawan/edit', [
                'karyawan' => $karyawan,
                'judul' => 'Edit Karyawan'
            ]);
        } catch (\Exception $e) {
            // Redirect dengan error message
            $_SESSION['error'] = 'Gagal mengambil data: ' . $e->getMessage();
            header('Location: index.php?url=karyawan');
            exit;
        }
    }

    public function update(int $id): void
    {
        // Validasi method request
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?url=karyawan');
            exit;
        }

        // Inisialisasi errors
        $errors = [];

        // Sanitize input - HAPUS EMAIL
        $nama = trim($_POST['nama'] ?? '');
        $jabatan = trim($_POST['jabatan'] ?? '');
        $gaji = trim($_POST['gaji'] ?? '');
        $tanggal_masuk = trim($_POST['tanggal_masuk'] ?? '');

        // ? Validasi Nama
        if (empty($nama)) {
            $errors[] = 'Nama harus diisi';
        } elseif (strlen($nama) < 3) {
            $errors[] = 'Nama minimal 3 karakter';
        }

        // ? Validasi Jabatan
        if (empty($jabatan)) {
            $errors[] = 'Jabatan harus diisi';
        } elseif (strlen($jabatan) < 3) {
            $errors[] = 'Jabatan minimal 3 karakter';
        }

        // ? Validasi Gaji
        if (empty($gaji)) {
            $errors[] = 'Gaji harus diisi';
        } elseif (!is_numeric($gaji)) {
            $errors[] = 'Gaji harus berupa angka';
        } elseif ($gaji <= 0) {
            $errors[] = 'Gaji harus bernilai positif';
        }

        // ? Validasi Tanggal Masuk
        if (empty($tanggal_masuk)) {
            $errors[] = 'Tanggal masuk harus diisi';
        } elseif (!strtotime($tanggal_masuk)) {
            $errors[] = 'Format tanggal tidak valid';
        }

        // ? Jika ada errors, tampilkan form kembali dengan data lama
        if (!empty($errors)) {
            try {
                $karyawan = $this->karyawanModel->getKaryawanById($id);

                if (!$karyawan) {
                    $_SESSION['error'] = 'Data karyawan tidak ditemukan!';
                    header('Location: index.php?url=karyawan');
                    exit;
                }

                $this->view('karyawan/edit', [
                    'karyawan' => $karyawan,
                    'judul' => 'Edit Karyawan',
                    'errors' => $errors,
                    'old' => [
                        'nama' => $nama,
                        'jabatan' => $jabatan,
                        'gaji' => $gaji,
                        'tanggal_masuk' => $tanggal_masuk
                    ]
                ]);
                return;
            } catch (\Exception $e) {
                // Redirect dengan error message
                $_SESSION['error'] = 'Gagal: ' . $e->getMessage();
                header('Location: index.php?url=karyawan');
                exit;
            }
        }

        // ? Jika validasi sukses, update data
        try {
            $data = [
                'nama' => $nama,
                'jabatan' => $jabatan,
                'gaji' => (float) $gaji,
                'tanggal_masuk' => $tanggal_masuk
            ];

            $result = $this->karyawanModel->update($id, $data);

            if ($result) {
                $_SESSION['success'] = 'Data karyawan berhasil diperbarui!';
                header('Location: index.php?url=karyawan');
                exit;
            } else {
                throw new \Exception("Update gagal tanpa error message");
            }
        } catch (\Exception $e) {
            // Redirect dengan error message
            $_SESSION['error'] = 'Gagal mengupdate data: ' . $e->getMessage();
            header('Location: index.php?url=karyawan&action=edit&id=' . $id);
            exit;
        }
    }

    // ? Delete Method
    public function delete(int $id): void
    {
        try {
            $this->karyawanModel->delete($id);
            $_SESSION['success'] = 'Data karyawan berhasil dihapus!';
            header('Location: index.php?url=karyawan');
            exit;
        } catch (\Exception $e) {
            // Redirect dengan error message
            $_SESSION['error'] = 'Gagal menghapus data: ' . $e->getMessage();
            header('Location: index.php?url=karyawan');
            exit;
        }
    }
}
