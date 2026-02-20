<?php

namespace App\Controllers;

use App\Models\KaryawanModel;
use Core\Controller;

class KaryawanController extends Controller
{
    private KaryawanModel $karyawanModel;

    public function __construct()
    {
        $this->karyawanModel = new KaryawanModel;
    }

    public function index(): void
    {
        try {
            $karyawan = $this->karyawanModel->getAllKaryawan();
            $this->view('karyawan/index', [
                'karyawan' => $karyawan,
                'judul' => 'Daftar Karyawan'
            ]);
        } catch (\Exception $e) {
            $this->view('error', [
                'message' => 'Gagal mengambil data karyawan: ' . $e->getMessage()
            ]);
        }
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
            header('Location: /?url=karyawan');
            exit;
        }

        // Inisialisasi errors
        $errors = [];

        // Sanitize input
        $nama = trim($_POST['nama'] ?? '');
        $email = trim($_POST['email'] ?? '');
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
                    'email' => $email,
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
                'email' => $email,
                'jabatan' => $jabatan,
                'gaji' => (float) $gaji, // Convert ke float
                'tanggal_masuk' => $tanggal_masuk
            ];

            $this->karyawanModel->create($data);
            header('Location: index.php?url=karyawan');
            exit;
        } catch (\Exception $e) {
            $this->view('error', [
                'message' => 'Gagal menyimpan data: ' . $e->getMessage()
            ]);
        }
    }

    public function edit(int $id): void
    {
        try {
            $karyawan = $this->karyawanModel->getKaryawanById($id);

            if (!$karyawan) {
                header('Location: index.php?url=karyawan');
                exit;
            }

            $this->view('karyawan/edit', [
                'karyawan' => $karyawan,
                'judul' => 'Edit Karyawan'
            ]);
        } catch (\Exception $e) {
            $this->view('error', [
                'message' => 'Gagal mengambil data: ' . $e->getMessage()
            ]);
        }
    }

    public function update(int $id): void
    {
        // Validasi method request
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /?url=karyawan');
            exit;
        }

        // Inisialisasi errors
        $errors = [];

        // Sanitize input
        $nama = trim($_POST['nama'] ?? '');
        $email = trim($_POST['email'] ?? '');
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

        // Jika ada errors, tampilkan form kembali dengan data lama
        if (!empty($errors)) {
            try {
                $karyawan = $this->karyawanModel->getKaryawanById($id);

                if (!$karyawan) {
                    header('Location: /?url=karyawan');
                    exit;
                }

                $this->view('karyawan/edit', [
                    'karyawan' => $karyawan,
                    'judul' => 'Edit Karyawan',
                    'errors' => $errors,
                    'old' => [
                        'nama' => $nama,
                        'email' => $email,
                        'jabatan' => $jabatan,
                        'gaji' => $gaji,
                        'tanggal_masuk' => $tanggal_masuk
                    ]
                ]);
                return;
            } catch (\Exception $e) {
                $this->view('error', [
                    'message' => 'Gagal: ' . $e->getMessage()
                ]);
                return;
            }
        }

        // Jika validasi sukses, update data
        try {
            $data = [
                'nama' => $nama,
                'email' => $email,
                'jabatan' => $jabatan,
                'gaji' => (float) $gaji,
                'tanggal_masuk' => $tanggal_masuk
            ];

            $this->karyawanModel->update($id, $data);
            header('Location: index.php?url=karyawan');
            exit;
        } catch (\Exception $e) {
            $this->view('error', [
                'message' => 'Gagal mengupdate data: ' . $e->getMessage()
            ]);
        }
    }

    public function delete(int $id): void
    {
        try {
            $this->karyawanModel->delete($id);
            header('Location: index.php?url=karyawan');
            exit;
        } catch (\Exception $e) {
            $this->view('error', [
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ]);
        }
    }
}
