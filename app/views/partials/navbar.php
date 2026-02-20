<!-- Navigation -->
<nav class="gradient-bg text-white shadow-lg">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-4">
            <!-- Brand -->
            <div class="flex items-center space-x-3">
                <div class="bg-white/20 p-2 rounded-lg">
                    <i class="bi bi-people-fill text-xl"></i>
                </div>
                <div>
                    <?php if (isset($_SESSION['user'])): ?>
                        <a href="index.php?url=karyawan" class="text-xl font-bold hover:opacity-90 transition">
                            Sistem Karyawan
                        </a>
                    <?php else: ?>
                        <a href="index.php?url=auth&action=login" class="text-xl font-bold hover:opacity-90 transition">
                            Sistem Karyawan
                        </a>
                    <?php endif; ?>
                    <p class="text-white/80 text-sm">Manajemen Data Karyawan</p>
                </div>
            </div>

            <!-- Auth Section -->
            <div class="flex items-center space-x-4">
                <?php if (isset($_SESSION['user'])): ?>
                    <!-- Jika sudah login -->
                    <div class="flex items-center space-x-3">
                        <div class="bg-white/20 px-3 py-1 rounded-full">
                            <i class="bi bi-person-circle mr-2"></i>
                            <span class="font-medium"><?= htmlspecialchars($_SESSION['user']['username']) ?></span>
                            <span class="ml-2 px-2 py-0.5 bg-blue-500 rounded-full text-xs">
                                <?= $_SESSION['user']['role'] ?>
                            </span>
                        </div>

                        <!-- Menu untuk Admin -->
                        <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                            <a href="index.php?url=karyawan"
                                class="px-4 py-2 rounded-lg <?= ($_GET['url'] ?? '') == 'karyawan' ? 'bg-white/20' : 'hover:bg-white/10' ?> transition">
                                <i class="bi bi-house-door mr-2"></i> Dashboard
                            </a>
                            <a href="index.php?url=karyawan&action=create"
                                class="px-4 py-2 rounded-lg <?= ($_GET['action'] ?? '') == 'create' ? 'bg-white/20' : 'hover:bg-white/10' ?> transition">
                                <i class="bi bi-person-plus mr-2"></i> Tambah
                            </a>
                        <?php endif; ?>

                        <!-- Logout Button -->
                        <a href="index.php?url=auth&action=logout"
                            class="px-4 py-2 rounded-lg bg-red-500/20 hover:bg-red-500/30 transition">
                            <i class="bi bi-box-arrow-right mr-2"></i> Logout
                        </a>
                    </div>
                <?php else: ?>
                    <!-- Jika belum login -->
                    <div class="bg-white/20 px-4 py-2 rounded-full">
                        <i class="bi bi-calendar3 mr-2"></i>
                        <?= date('d F Y') ?>
                    </div>

                    <a href="index.php?url=auth&action=login"
                        class="px-4 py-2 rounded-lg bg-white/20 hover:bg-white/30 transition">
                        <i class="bi bi-box-arrow-in-right mr-2"></i> Login Admin
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>