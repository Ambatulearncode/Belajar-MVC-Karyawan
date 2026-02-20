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
                        <span class="text-gray-500">Tambah Karyawan</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Title -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
            <div class="mb-4 md:mb-0">
                <h1 class="text-3xl font-bold text-gray-800">Tambah Karyawan Baru</h1>
                <p class="text-gray-600 mt-2">Isi form berikut untuk menambahkan data karyawan baru</p>
            </div>
            <a href="<?= url('/?url=karyawan') ?>"
                class="joko-btn joko-btn-secondary inline-flex items-center">
                <i class="bi bi-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>
    </div>

    <!-- Error Messages -->
    <?php if (!empty($errors)): ?>
        <div class="joko-alert joko-alert-danger mb-6 animate-fade-in">
            <div class="flex items-start">
                <i class="bi bi-exclamation-triangle text-xl mr-3 mt-0.5"></i>
                <div>
                    <h4 class="font-bold mb-2">Perbaiki kesalahan berikut:</h4>
                    <ul class="list-disc pl-5 space-y-1">
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Form Card -->
    <div class="bg-white rounded-xl card-shadow p-6 md:p-8">
        <form method="POST" action="?url=karyawan&action=store" class="space-y-6">
            <!-- Nama Field -->
            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="bi bi-person mr-1"></i>
                    Nama Lengkap <span class="text-red-500">*</span>
                </label>
                <input type="text"
                    id="nama"
                    name="nama"
                    value="<?= isset($old['nama']) ? htmlspecialchars($old['nama']) : '' ?>"
                    class="joko-input w-full <?= isset($errors) && isset($old['nama']) ? 'border-red-300' : '' ?>"
                    placeholder="Masukkan nama lengkap karyawan"
                    required>
                <?php if (isset($errors) && isset($old['nama'])): ?>
                    <p class="mt-1 text-sm text-red-600">
                        <i class="bi bi-exclamation-circle mr-1"></i>
                        Nama harus diisi dan minimal 3 karakter
                    </p>
                <?php endif; ?>
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
                    <option value="Manager" <?= (isset($old['jabatan']) && $old['jabatan'] == 'Manager') ? 'selected' : '' ?>>Manager</option>
                    <option value="Supervisor" <?= (isset($old['jabatan']) && $old['jabatan'] == 'Supervisor') ? 'selected' : '' ?>>Supervisor</option>
                    <option value="Staff IT" <?= (isset($old['jabatan']) && $old['jabatan'] == 'Staff IT') ? 'selected' : '' ?>>Staff IT</option>
                    <option value="HRD" <?= (isset($old['jabatan']) && $old['jabatan'] == 'HRD') ? 'selected' : '' ?>>HRD</option>
                    <option value="Accounting" <?= (isset($old['jabatan']) && $old['jabatan'] == 'Accounting') ? 'selected' : '' ?>>Accounting</option>
                    <option value="Marketing" <?= (isset($old['jabatan']) && $old['jabatan'] == 'Marketing') ? 'selected' : '' ?>>Marketing</option>
                    <option value="Staff Admin" <?= (isset($old['jabatan']) && $old['jabatan'] == 'Staff Admin') ? 'selected' : '' ?>>Staff Admin</option>
                    <option value="Operator" <?= (isset($old['jabatan']) && $old['jabatan'] == 'Operator') ? 'selected' : '' ?>>Operator</option>
                </select>
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
                        value="<?= isset($old['gaji']) ? htmlspecialchars($old['gaji']) : '' ?>"
                        class="joko-input w-full pl-12"
                        placeholder="0"
                        min="0"
                        step="100000"
                        required>
                </div>
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
                    value="<?= isset($old['tanggal_masuk']) ? htmlspecialchars($old['tanggal_masuk']) : '' ?>"
                    class="joko-input w-full"
                    required>
            </div>

            <!-- Form Actions -->
            <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                <button type="submit"
                    class="joko-btn joko-btn-primary flex-1 inline-flex items-center justify-center">
                    <i class="bi bi-check-circle mr-2"></i>
                    Simpan Data
                </button>
                <a href="?url=karyawan&action=store"
                    class="joko-btn joko-btn-secondary flex-1 inline-flex items-center justify-center">
                    <i class="bi bi-x-circle mr-2"></i>
                    Batal
                </a>
            </div>
        </form>
    </div>

    <!-- Form Tips -->
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="bi bi-info-circle text-blue-400 text-xl"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800">Tips Pengisian Form</h3>
                <div class="mt-2 text-sm text-blue-700">
                    <ul class="list-disc pl-5 space-y-1">
                        <li>Pastikan semua field yang bertanda <span class="text-red-500">*</span> diisi</li>
                        <li>Email harus valid dan aktif</li>
                        <li>Gaji diisi tanpa titik atau koma</li>
                        <li>Data akan langsung tersimpan setelah tombol "Simpan" ditekan</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>