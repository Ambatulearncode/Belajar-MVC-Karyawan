<div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <!-- Breadcrumb -->
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="<?= url('/?url=admin') ?>"
                        class="inline-flex items-center text-blue-600 hover:text-blue-800">
                        <i class="bi bi-shield-lock mr-2"></i>
                        Admin Panel
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="bi bi-chevron-right text-gray-400 mx-2"></i>
                        <span class="text-gray-500">Edit Admin</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Title -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
            <div class="mb-4 md:mb-0">
                <h1 class="text-3xl font-bold text-gray-800">Edit Data Admin</h1>
                <p class="text-gray-600 mt-2">Perbarui data admin <?= htmlspecialchars($admin['username']) ?></p>
            </div>
            <a href="<?= url('/?url=admin') ?>"
                class="joko-btn joko-btn-secondary inline-flex items-center">
                <i class="bi bi-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>
    </div>

    <!-- Success Message -->
    <?php if (!empty($_SESSION['success'])): ?>
        <div class="joko-alert joko-alert-success mb-6 animate-fade-in">
            <div class="flex items-start">
                <i class="bi bi-check-circle text-xl mr-3 mt-0.5"></i>
                <div>
                    <p class="font-bold"><?= htmlspecialchars($_SESSION['success']) ?></p>
                </div>
            </div>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

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
        <form method="POST" action="?url=admin&action=update&id=<?= $admin['id'] ?>" class="space-y-4">
            <!-- Username Field -->
            <div class="pb-3 border-b border-gray-200">
                <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="bi bi-person-badge mr-1"></i>
                    Username <span class="text-red-500">*</span>
                </label>
                <input type="text"
                    id="username"
                    name="username"
                    value="<?= isset($old['username']) ? htmlspecialchars($old['username']) : htmlspecialchars($admin['username']) ?>"
                    class="joko-input w-full <?= isset($errors) && isset($old['username']) ? 'border-red-300' : '' ?>"
                    placeholder="Masukkan username admin"
                    required
                    minlength="3">
                <?php if (isset($errors) && isset($old['username'])): ?>
                    <p class="mt-1 text-sm text-red-600">
                        <i class="bi bi-exclamation-circle mr-1"></i>
                        Username minimal 3 karakter dan harus unik
                    </p>
                <?php endif; ?>
                <p class="mt-1 text-sm text-gray-500">
                    <i class="bi bi-info-circle mr-1"></i>
                    Username akan digunakan untuk login
                </p>
            </div>

            <!-- Email Field -->
            <div class="pb-3 border-b border-gray-200">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="bi bi-envelope mr-1"></i>
                    Email <span class="text-red-500">*</span>
                </label>
                <input type="email"
                    id="email"
                    name="email"
                    value="<?= isset($old['email']) ? htmlspecialchars($old['email']) : htmlspecialchars($admin['email']) ?>"
                    class="joko-input w-full <?= isset($errors) && isset($old['email']) ? 'border-red-300' : '' ?>"
                    placeholder="admin@example.com"
                    required>
                <?php if (isset($errors) && isset($old['email'])): ?>
                    <p class="mt-1 text-sm text-red-600">
                        <i class="bi bi-exclamation-circle mr-1"></i>
                        Email harus valid dan belum terdaftar
                    </p>
                <?php endif; ?>
                <p class="mt-1 text-sm text-gray-500">
                    <i class="bi bi-info-circle mr-1"></i>
                    Gunakan email aktif untuk verifikasi
                </p>
            </div>

            <!-- Role Field -->
            <div class="pb-3 border-b border-gray-200">
                <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="bi bi-shield mr-1"></i>
                    Role <span class="text-red-500">*</span>
                </label>
                <select id="role"
                    name="role"
                    class="joko-select w-full"
                    required>
                    <option value="">Pilih Role</option>
                    <option value="admin" <?= (isset($old['role']) ? $old['role'] : $admin['role']) == 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="superadmin" <?= (isset($old['role']) ? $old['role'] : $admin['role']) == 'superadmin' ? 'selected' : '' ?>>Super Admin</option>
                </select>
                <p class="mt-1 text-sm text-gray-500">
                    <i class="bi bi-info-circle mr-1"></i>
                    <span class="text-yellow-600">Super Admin</span> bisa mengelola admin lain
                </p>
            </div>

            <!-- Password Field (Optional) -->
            <div class="pb-3 border-b border-gray-200">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="bi bi-lock mr-1"></i>
                    Password Baru <span class="text-gray-400">(opsional)</span>
                </label>
                <input type="password"
                    id="password"
                    name="password"
                    class="joko-input w-full <?= isset($errors) && isset($old['password']) ? 'border-red-300' : '' ?>"
                    placeholder="Kosongkan jika tidak ingin mengubah password"
                    minlength="6">
                <?php if (isset($errors) && isset($old['password'])): ?>
                    <p class="mt-1 text-sm text-red-600">
                        <i class="bi bi-exclamation-circle mr-1"></i>
                        Password minimal 6 karakter
                    </p>
                <?php endif; ?>
                <p class="mt-1 text-sm text-gray-500">
                    <i class="bi bi-info-circle mr-1"></i>
                    Gunakan kombinasi huruf, angka, dan simbol untuk keamanan
                </p>
            </div>

            <!-- Confirm Password Field -->
            <div class="pb-3">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="bi bi-lock-fill mr-1"></i>
                    Konfirmasi Password Baru
                </label>
                <input type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    class="joko-input w-full"
                    placeholder="Ketik ulang password baru"
                    minlength="6">
                <p class="mt-1 text-sm text-gray-500">
                    <i class="bi bi-info-circle mr-1"></i>
                    Ketik ulang password untuk konfirmasi
                </p>
            </div>

            <!-- Form Actions -->
            <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-200">
                <!-- Update Button (Purple for Admin) -->
                <button type="submit"
                    class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-4 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 flex-1 inline-flex items-center justify-center">
                    <i class="bi bi-shield-check mr-2"></i>
                    Update Admin
                </button>

                <!-- Batal Button -->
                <a href="?url=admin"
                    class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-3 px-4 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 flex-1 inline-flex items-center justify-center">
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
                <h3 class="text-sm font-medium text-blue-800">Tips Update Admin</h3>
                <div class="mt-2 text-sm text-blue-700">
                    <ul class="list-disc pl-5 space-y-1">
                        <li>Pastikan semua field yang bertanda <span class="text-red-500">*</span> diisi</li>
                        <li>Username harus unik dan tidak boleh sama dengan admin lain</li>
                        <li>Gunakan email aktif untuk memudahkan komunikasi</li>
                        <li>Password minimal 6 karakter untuk keamanan</li>
                        <li>Role Super Admin memiliki akses penuh ke seluruh sistem</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Warning for Super Admin -->
    <?php if ($admin['role'] === 'superadmin'): ?>
        <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="bi bi-exclamation-triangle text-yellow-400 text-xl"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800">Peringatan: Super Admin</h3>
                    <div class="mt-2 text-sm text-yellow-700">
                        <p>Anda sedang mengedit akun <strong>Super Admin</strong>. Perubahan pada akun ini akan mempengaruhi seluruh sistem. Harap berhati-hati!</p>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>