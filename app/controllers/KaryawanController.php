<?php

namespace App\controllers;

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
            $this->view('karyawan/index', ['karyawan' => $karyawan, 'judul' => 'Daftar Karyawan']);
        } catch (\Exception $e) {
            $this->view('error', ['message' => 'Gagal mengambil data karyawan' . $e->getMessage()]);
        }
    }

    public function create(): void
    {
        $this->view('karyawan/create', ['judul' => 'Tambah Karyawan']);
    }

    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/karyawan');
            return;
        }

        try {
            $data = [
                'nama' => $_POST['nama'] ?? '',
                'jabatan' => $_POST['jabatan'] ?? '',
                'gaji' => $_POST['gaji'] ?? '',
                'tanggal_masuk' => $_POST['tanggal_masuk'] ?? 0
            ];

            $this->karyawanModel->create($data);
            $this->redirect('/karyawan');
        } catch (\Exception $e) {
            $this->view('error', ['message' => 'Gagal meyimpan data: ' . $e->getMessage()]);
        }
    }

    public function edit(int $id): void
    {
        try {
            $karyawan = $this->karyawanModel->getKaryawanById($id);

            if (!$karyawan) {
                $this->redirect('/karyawan');
                return;
            }

            $this->view('karyawan/edit', ['karyawan' => $karyawan]);
        } catch (\Exception $e) {
            $this->view('error', ['message' => 'Gagal mengambil data: ' . $e->getMessage()]);
        }
    }

    public function update(int $id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/karyawan');
            return;
        }

        try {
            $data = [
                'nama' => $_POST['nama'] ?? '',
                'jabatan' => $_POST['jabatan'] ?? '',
                'gaji' => $_POST['gaji'] ?? '',
                'tanggal_masuk' => $_POST['tanggal_masuk'] ?? 0
            ];

            $this->karyawanModel->update($id, $data);
            $this->redirect('/karyawan');
        } catch (\Exception $e) {
            $this->view('error', ['message' => 'Gagal mengupdate data: ' . $e->getMessage()]);
        }
    }

    public function delete(int $id): void
    {
        try {
            $this->karyawanModel->delete($id);
            $this->redirect('/karyawan');
        } catch (\Exception $e) {
            $this->view('error', ['message' => 'Gagal menghapus data: ' . $e->getMessage()]);
        }
    }
}
