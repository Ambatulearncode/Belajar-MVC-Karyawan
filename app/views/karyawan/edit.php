<div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <!-- Breadcrumb -->
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="<?= url('/?url=karyawan') ?>"
                        class="inline-flex items-center text-blue-600 hover:text-blue-800">
                        <i class="bi bi-house-door mr-2"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="bi bi-chevron-right text-gray-400 mx-2"></i>
                        <span class="text-gray-500">Edit Karyawan</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Title -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
            <div class="mb-4 md:mb-0">
                <h1 class="text-3xl font-bold text-gray-800">Edit Data Karyawan</h1>
                <p class="text-gray-600 mt-2">Perbarui data karyawan <?= htmlspecialchars($karyawan['nama']) ?></p>
            </div>
            <a href="<?= url('/?url=karyawan') ?>"
                class="joko-btn joko-btn-secondary inline-flex items-center">
                <i class="bi bi-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl card-shadow p-6 md:p-8">
        <form method="POST" action="index.php?url=karyawan&action=update&id=<?= $karyawan['id'] ?>" class="space-y-6">
            <!-- Nama Field -->
            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="bi bi-person mr-1"></i>
                    Nama Lengkap <span class="text-red-500">*</span>
                </label>
                <input type="text"
                    id="nama"
                    name="nama"
                    value="<?= htmlspecialchars($karyawan['nama']) ?>"
                    class="joko-input w-full"
                    placeholder="Masukkan nama lengkap karyawan"
                    required>
            </div>

            <!-- Jabatan Field -->
            <div>
                <label for="jabatan" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="bi bi-briefcase mr-1"></i>
                    Jabatan <span class="text-red-500">*</span>
                </label>
                <select id="jabatan"
                    name="jabatan"
                    class="joko-select w-full"
                    required>
                    <option value="">Pilih Jabatan</option>
                    <option value="Manager" <?= $karyawan['jabatan'] == 'Manager' ? 'selected' : '' ?>>Manager</option>
                    <option value="Supervisor" <?= $karyawan['jabatan'] == 'Supervisor' ? 'selected' : '' ?>>Supervisor</option>
                    <option value="Staff IT" <?= $karyawan['jabatan'] == 'Staff IT' ? 'selected' : '' ?>>Staff IT</option>
                    <option value="HRD" <?= $karyawan['jabatan'] == 'HRD' ? 'selected' : '' ?>>HRD</option>
                    <option value="Accounting" <?= $karyawan['jabatan'] == 'Accounting' ? 'selected' : '' ?>>Accounting</option>
                    <option value="Marketing" <?= $karyawan['jabatan'] == 'Marketing' ? 'selected' : '' ?>>Marketing</option>
                    <option value="Staff Admin" <?= $karyawan['jabatan'] == 'Staff Admin' ? 'selected' : '' ?>>Staff Admin</option>
                    <option value="Operator" <?= $karyawan['jabatan'] == 'Operator' ? 'selected' : '' ?>>Operator</option>
                </select>
            </div>
            <!-- Tanggal Masuk Field -->
            <div>
                <label for="tanggal_masuk" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="bi bi-calendar3 mr-1"></i>
                    Tanggal Masuk <span class="text-red-500">*</span>
                </label>
                <input type="date"
                    id="tanggal_masuk"
                    name="tanggal_masuk"
                    value="<?= htmlspecialchars($karyawan['tanggal_masuk'] ?? '') ?>"
                    class="joko-input w-full"
                    required>
            </div>
            <!-- Gaji Field -->
            <div>
                <label for="gaji" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="bi bi-cash-coin mr-1"></i>
                    Gaji <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500">Rp</span>
                    </div>
                    <input type="number"
                        id="gaji"
                        name="gaji"
                        value="<?= $karyawan['gaji'] ?>"
                        class="joko-input w-full pl-12"
                        placeholder="0"
                        min="0"
                        step="100000"
                        required>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                <button type="submit"
                    class="joko-btn joko-btn-primary flex-1 inline-flex items-center justify-center">
                    <i class="bi bi-check-circle mr-2"></i>
                    Update Data
                </button>
                <a href="?url=karyawan&action=edit"
                    class="joko-btn joko-btn-secondary flex-1 inline-flex items-center justify-center">
                    <i class="bi bi-x-circle mr-2"></i>
                    Batal
                </a>
            </div>
        </form>
    </div>

    <!-- Employee Info -->
    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Current Info -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-center mb-3">
                <div class="bg-blue-100 p-2 rounded-lg mr-3">
                    <i class="bi bi-info-circle text-blue-600"></i>
                </div>
                <h3 class="text-sm font-medium text-blue-800">Informasi Saat Ini</h3>
            </div>
            <div class="space-y-2">
                <div class="flex justify-between">
                    <span class="text-sm text-blue-700">ID Karyawan:</span>
                    <span class="text-sm font-medium text-blue-900">#<?= $karyawan['id'] ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-blue-700">Nama:</span>
                    <span class="text-sm font-medium text-blue-900"><?= htmlspecialchars($karyawan['nama']) ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-blue-700">Jabatan:</span>
                    <span class="text-sm font-medium text-blue-900"><?= htmlspecialchars($karyawan['jabatan']) ?></span>
                </div>
            </div>
        </div>

        <!-- Update Tips -->
        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex items-center mb-3">
                <div class="bg-green-100 p-2 rounded-lg mr-3">
                    <i class="bi bi-lightbulb text-green-600"></i>
                </div>
                <h3 class="text-sm font-medium text-green-800">Tips Update Data</h3>
            </div>
            <div class="text-sm text-green-700">
                <ul class="list-disc pl-5 space-y-1">
                    <li>Pastikan data yang diupdate sudah benar</li>
                    <li>Perubahan gaji akan berlaku mulai bulan depan</li>
                    <li>Klik "Update Data" untuk menyimpan perubahan</li>
                </ul>
            </div>
        </div>
    </div>
</div>