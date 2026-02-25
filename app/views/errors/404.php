<div class="min-h-[70vh] flex items-center justify-center px-4 py-12">
    <div class="max-w-3xl w-full text-center">
        <!-- Animasi 404 dengan Joko UI -->
        <div class="relative mb-8">
            <!-- Angka 404 dengan efek -->
            <div class="text-9xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 animate-pulse">
                404
            </div>

            <!-- Ilustrasi (opsional) -->
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 opacity-10">
                <i class="bi bi-robot text-[12rem] text-gray-800"></i>
            </div>
        </div>

        <!-- Icon besar (Joko UI style) -->
        <div class="flex justify-center mb-6">
            <div class="joko-icon-circle bg-gradient-to-r from-blue-500 to-purple-600 p-6 rounded-full shadow-xl">
                <i class="bi bi-compass text-6xl text-white"></i>
            </div>
        </div>

        <!-- Title -->
        <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
            Halaman Tidak Ditemukan
        </h1>

        <!-- Description -->
        <p class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto">
            Maaf, halaman yang Anda cari mungkin telah dipindahkan,
            dihapus, atau tidak pernah ada. Jangan khawatir, masih banyak
            hal menarik lainnya di sini!
        </p>

        <!-- Suggestions Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <!-- Card 1: Dashboard -->
            <div class="joko-card p-6 bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex flex-col items-center">
                    <div class="joko-icon-circle bg-blue-100 p-3 rounded-full mb-3">
                        <i class="bi bi-house-door text-2xl text-blue-600"></i>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-2">Dashboard</h3>
                    <p class="text-sm text-gray-600 text-center mb-3">Kembali ke halaman utama</p>
                    <a href="index.php?url=karyawan"
                        class="joko-btn joko-btn-sm bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                        <i class="bi bi-arrow-right mr-1"></i> Ke Dashboard
                    </a>
                </div>
            </div>

            <!-- Card 2: Daftar Karyawan -->
            <div class="joko-card p-6 bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex flex-col items-center">
                    <div class="joko-icon-circle bg-green-100 p-3 rounded-full mb-3">
                        <i class="bi bi-people text-2xl text-green-600"></i>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-2">Karyawan</h3>
                    <p class="text-sm text-gray-600 text-center mb-3">Lihat daftar karyawan</p>
                    <a href="index.php?url=karyawan"
                        class="joko-btn joko-btn-sm bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                        <i class="bi bi-arrow-right mr-1"></i> Ke Karyawan
                    </a>
                </div>
            </div>

            <!-- Card 3: Activity Log -->
            <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'superadmin'): ?>
                <div class="joko-card p-6 bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex flex-col items-center">
                        <div class="joko-icon-circle bg-purple-100 p-3 rounded-full mb-3">
                            <i class="bi bi-activity text-2xl text-purple-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-2">Activity Log</h3>
                        <p class="text-sm text-gray-600 text-center mb-3">Lihat aktivitas sistem</p>
                        <a href="index.php?url=activity-log"
                            class="joko-btn joko-btn-sm bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition">
                            <i class="bi bi-arrow-right mr-1"></i> Ke Activity Log
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Search Bar (opsional) -->
        <div class="max-w-md mx-auto">
            <form action="index.php?url=karyawan" method="GET" class="flex">
                <input type="hidden" name="url" value="karyawan">
                <input type="text"
                    name="search"
                    placeholder="Cari karyawan..."
                    class="flex-1 px-4 py-3 border border-gray-300 rounded-l-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-r-lg font-medium transition">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>

        <!-- Tombol Kembali (Mobile friendly) -->
        <div class="mt-8 flex justify-center space-x-3">
            <button onclick="history.back()"
                class="joko-btn bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-medium transition flex items-center">
                <i class="bi bi-arrow-left mr-2"></i>
                Kembali
            </button>
            <a href="index.php?url=auth&action=logout"
                class="joko-btn bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-medium transition flex items-center">
                <i class="bi bi-box-arrow-right mr-2"></i>
                Logout
            </a>
        </div>

        <!-- Error Info (hidden, untuk debugging) -->
        <?php if (isset($_GET['debug']) && $_SESSION['user']['role'] === 'superadmin'): ?>
            <div class="mt-8 p-4 bg-gray-100 rounded-lg text-left">
                <p class="text-sm font-mono text-gray-600">
                    <strong>Debug Info:</strong><br>
                    URL: <?= htmlspecialchars($_GET['url'] ?? '') ?><br>
                    Action: <?= htmlspecialchars($_GET['action'] ?? '') ?><br>
                    ID: <?= htmlspecialchars($_GET['id'] ?? '') ?><br>
                    Time: <?= date('Y-m-d H:i:s') ?>
                </p>
            </div>
        <?php endif; ?>
    </div>
</div>