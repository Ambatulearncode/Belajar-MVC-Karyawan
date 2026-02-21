<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
            <div class="mb-4 md:mb-0">
                <h1 class="text-3xl font-bold text-gray-800">Dashboard User</h1>
                <p class="text-gray-600 mt-2">Selamat datang di sistem manajemen karyawan</p>
            </div>
            <div class="flex items-center space-x-4">
                <div class="bg-green-100 px-4 py-2 rounded-lg">
                    <span class="text-sm text-gray-600">Login sebagai:</span>
                    <span class="font-bold text-green-700 ml-2"><?= htmlspecialchars($user['username']) ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Welcome Card -->
    <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl shadow-lg text-white p-8 mb-8">
        <div class="flex flex-col md:flex-row items-center justify-between">
            <div class="mb-6 md:mb-0 md:mr-8">
                <h2 class="text-2xl font-bold mb-4">Selamat Datang, <?= htmlspecialchars($user['username']) ?>!</h2>
                <p class="text-blue-100 mb-4">
                    Anda login sebagai <span class="font-bold"><?= htmlspecialchars($user['role']) ?></span>.
                    Sistem ini digunakan untuk mengelola data karyawan perusahaan.
                </p>
                <div class="flex items-center space-x-4">
                    <div class="bg-white/20 px-4 py-2 rounded-lg">
                        <i class="bi bi-envelope mr-2"></i>
                        <?= htmlspecialchars($user['email']) ?>
                    </div>
                    <div class="bg-white/20 px-4 py-2 rounded-lg">
                        <i class="bi bi-calendar3 mr-2"></i>
                        <?= date('d F Y') ?>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <div class="bg-white/20 p-6 rounded-full inline-block">
                    <i class="bi bi-person-circle text-6xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Information Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Role Information -->
        <div class="bg-white rounded-xl card-shadow p-6">
            <div class="flex items-center mb-4">
                <div class="bg-blue-100 p-3 rounded-lg mr-4">
                    <i class="bi bi-person-badge text-blue-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Hak Akses</h3>
                    <p class="text-gray-600 text-sm">Informasi peran Anda</p>
                </div>
            </div>
            <div class="mt-4">
                <p class="text-gray-700">
                    Sebagai <span class="font-bold text-blue-600"><?= htmlspecialchars($user['role']) ?></span>,
                    Anda memiliki akses terbatas ke sistem.
                </p>
                <ul class="mt-3 space-y-2 text-sm text-gray-600">
                    <li class="flex items-center">
                        <i class="bi bi-check-circle text-green-500 mr-2"></i>
                        Melihat dashboard
                    </li>
                    <li class="flex items-center">
                        <i class="bi bi-x-circle text-red-500 mr-2"></i>
                        Tidak dapat mengelola karyawan
                    </li>
                    <li class="flex items-center">
                        <i class="bi bi-x-circle text-red-500 mr-2"></i>
                        Tidak dapat membuat admin baru
                    </li>
                </ul>
            </div>
        </div>

        <!-- System Info -->
        <div class="bg-white rounded-xl card-shadow p-6">
            <div class="flex items-center mb-4">
                <div class="bg-green-100 p-3 rounded-lg mr-4">
                    <i class="bi bi-info-circle text-green-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Informasi Sistem</h3>
                    <p class="text-gray-600 text-sm">Tentang aplikasi ini</p>
                </div>
            </div>
            <div class="mt-4">
                <p class="text-gray-700">
                    Sistem Manajemen Karyawan adalah aplikasi untuk mengelola data karyawan perusahaan.
                </p>
                <div class="mt-4 space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Versi</span>
                        <span class="font-medium">1.0.0</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Pengembang</span>
                        <span class="font-medium">Tim IT</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Terakhir Update</span>
                        <span class="font-medium"><?= date('d M Y') ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl card-shadow p-6">
            <div class="flex items-center mb-4">
                <div class="bg-purple-100 p-3 rounded-lg mr-4">
                    <i class="bi bi-lightning-charge text-purple-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Aksi Cepat</h3>
                    <p class="text-gray-600 text-sm">Tindakan yang dapat dilakukan</p>
                </div>
            </div>
            <div class="mt-4 space-y-3">
                <a href="index.php?url=auth&action=logout"
                    class="flex items-center justify-between p-3 bg-red-50 hover:bg-red-100 rounded-lg transition">
                    <div class="flex items-center">
                        <i class="bi bi-box-arrow-right text-red-600 mr-3"></i>
                        <span class="font-medium text-red-700">Logout</span>
                    </div>
                    <i class="bi bi-chevron-right text-red-400"></i>
                </a>

                <div class="p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <i class="bi bi-clock-history text-gray-600 mr-3"></i>
                        <div>
                            <span class="font-medium text-gray-700">Login Terakhir</span>
                            <p class="text-sm text-gray-500">Hari ini, <?= date('H:i') ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Note -->
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="bi bi-shield-check text-blue-400 text-xl"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800">Keamanan Akun</h3>
                <div class="mt-2 text-sm text-blue-700">
                    <p>
                        Pastikan untuk logout setelah menggunakan sistem, terutama jika menggunakan komputer bersama.
                        Jangan bagikan informasi login Anda kepada siapapun.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>