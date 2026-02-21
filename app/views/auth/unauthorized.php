<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 text-center">
        <!-- Error Icon -->
        <div class="mx-auto">
            <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-red-100">
                <i class="bi bi-shield-lock text-red-600 text-4xl"></i>
            </div>
        </div>

        <!-- Title -->
        <div>
            <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                Akses Ditolak
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Anda tidak memiliki izin untuk mengakses halaman ini
            </p>
        </div>

        <!-- Message -->
        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="bi bi-exclamation-triangle text-red-400"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">
                        Izin Tidak Memadai
                    </h3>
                    <div class="mt-2 text-sm text-red-700">
                        <p>
                            Hanya pengguna dengan hak akses tertentu yang dapat mengakses halaman ini.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Info -->
        <?php if (isset($_SESSION['user'])): ?>
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                <div class="flex items-center justify-center">
                    <div class="flex-shrink-0">
                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                            <i class="bi bi-person text-blue-600"></i>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900">
                            <?= htmlspecialchars($_SESSION['user']['username']) ?>
                        </p>
                        <p class="text-xs text-gray-500">
                            Role: <?= htmlspecialchars($_SESSION['user']['role']) ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Action Buttons -->
        <div class="space-y-4">
            <?php if (isset($_SESSION['user'])): ?>
                <!-- Jika sudah login -->
                <a href="index.php?url=karyawan"
                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                    <i class="bi bi-house-door mr-2"></i>
                    Kembali ke Dashboard
                </a>

                <a href="index.php?url=auth&action=logout"
                    class="w-full flex justify-center py-3 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                    <i class="bi bi-box-arrow-right mr-2"></i>
                    Logout
                </a>
            <?php else: ?>
                <!-- Jika belum login -->
                <a href="index.php?url=auth&action=login"
                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                    <i class="bi bi-box-arrow-in-right mr-2"></i>
                    Login ke Sistem
                </a>
            <?php endif; ?>
        </div>

        <!-- Help Text -->
        <div class="text-sm text-gray-500">
            <p>
                Jika Anda merasa ini adalah kesalahan, hubungi administrator sistem.
            </p>
        </div>
    </div>
</div>