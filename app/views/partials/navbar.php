<!-- Navigation -->
<nav class="gradient-bg text-white shadow-lg">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-4">
            <!-- Brand Logo -->
            <div class="flex items-center space-x-3">
                <div class="bg-white/20 p-2 rounded-lg hidden sm:block">
                    <i class="bi bi-people-fill text-xl"></i>
                </div>
                <div>
                    <?php if (isset($_SESSION['user'])): ?>
                        <a href="index.php?url=karyawan" class="text-lg sm:text-xl font-bold hover:opacity-90 transition">
                            Sistem Karyawan
                        </a>
                    <?php else: ?>
                        <a href="index.php?url=auth&action=login" class="text-lg sm:text-xl font-bold hover:opacity-90 transition">
                            Sistem Karyawan
                        </a>
                    <?php endif; ?>
                    <p class="text-white/80 text-xs sm:text-sm hidden sm:block">Manajemen Data Karyawan</p>
                </div>
            </div>

            <!-- Desktop Menu (Visible on medium screens and up) -->
            <div class="hidden md:flex items-center space-x-4">
                <?php if (isset($_SESSION['user'])): ?>
                    <!-- Jika sudah login -->
                    <div class="flex items-center space-x-3">
                        <!-- User badge dengan warna berbeda berdasarkan role -->
                        <div class="px-3 py-1 rounded-full <?=
                                                            $_SESSION['user']['username'] === 'admin' ? 'bg-purple-500/20 text-purple-300' : ($_SESSION['user']['role'] === 'admin' ? 'bg-blue-500/20 text-blue-300' :
                                                                'bg-green-400/20 text-green-300')
                                                            ?>">
                            <i class="bi bi-person-circle mr-2"></i>
                            <span class="font-medium hidden lg:inline">
                                <?= htmlspecialchars($_SESSION['user']['username']) ?>
                                <span class="text-xs ml-1">(<?= $_SESSION['user']['role'] ?>)</span>
                            </span>
                        </div>

                        <!-- Menu untuk SuperAdmin (role 'superadmin') -->
                        <?php if ($_SESSION['user']['role'] === 'superadmin'): ?>
                            <a href="index.php?url=karyawan"
                                class="px-3 py-2 rounded-lg <?= (($_GET['url'] ?? '') == 'karyawan' && ($_GET['action'] ?? '') != 'trash') == 'karyawan' ? 'bg-white/20' : 'hover:bg-white/10' ?> transition text-sm">
                                <i class="bi bi-people mr-1"></i> <span class="hidden lg:inline">Karyawan</span>
                            </a>
                            <a href="index.php?url=admin&action=index"
                                class="px-3 py-2 rounded-lg <?= ($_GET['url'] ?? '') == 'admin' ? 'bg-white/20' : 'hover:bg-white/10' ?> transition text-sm">
                                <i class="bi bi-person-badge mr-1"></i> <span class="hidden lg:inline">Admin</span>
                            </a>
                            <a href="index.php?url=activity-log"
                                class="px-3 py-2 rounded-lg <?= ($_GET['url'] ?? '') == 'activity-log' ? 'bg-white/20' : 'hover:bg-white/10' ?> transition text-sm">
                                <i class="bi bi-activity mr-1"></i> <span class="hidden lg:inline">Activity Log</span>
                            </a>
                            <a href="index.php?url=karyawan&action=trash"
                                class="px-3 py-2 rounded-lg <?= ($_GET['action'] ?? '') == 'trash' ? 'bg-white/20' : 'hover:bg-white/10 ' ?> transition text-sm">
                                <i class="bi bi-trash3 mr-1"></i> <span class="hidden lg:inline">Tong Sampah</span>
                            </a>
                            <!-- Menu untuk Admin biasa (role 'admin') -->
                        <?php elseif ($_SESSION['user']['role'] === 'admin'): ?>
                            <a href="index.php?url=karyawan"
                                class="px-3 py-2 rounded-lg <?= ($_GET['url'] ?? '') == 'karyawan' ? 'bg-white/20' : 'hover:bg-white/10' ?> transition text-sm">
                                <i class="bi bi-house-door mr-1"></i> <span class="hidden lg:inline">Dashboard</span>
                            </a>
                            <a href="index.php?url=karyawan&action=create"
                                class="px-3 py-2 rounded-lg <?= ($_GET['action'] ?? '') == 'create' ? 'bg-white/20' : 'hover:bg-white/10' ?> transition text-sm">
                                <i class="bi bi-person-plus mr-1"></i> <span class="hidden lg:inline">Tambah Karyawan</span>
                            </a>
                        <?php endif; ?>

                        <!-- Logout Button -->
                        <a href="index.php?url=auth&action=logout"
                            class="px-3 py-2 rounded-lg bg-red-500/20 hover:bg-red-500/30 transition text-sm">
                            <i class="bi bi-box-arrow-right mr-1"></i> <span class="hidden lg:inline">Logout</span>
                        </a>
                    </div>
                <?php else: ?>
                    <!-- Jika belum login -->
                    <div class="bg-white/20 px-4 py-2 rounded-full hidden lg:flex items-center">
                        <i class="bi bi-calendar3 mr-2"></i>
                        <?= date('d F Y') ?>
                    </div>

                    <a href="index.php?url=auth&action=login"
                        class="px-4 py-2 rounded-lg bg-white/20 hover:bg-white/30 transition">
                        <i class="bi bi-box-arrow-in-right mr-2"></i> <span class="hidden sm:inline">Login Admin</span>
                    </a>
                <?php endif; ?>
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden flex items-center">
                <?php if (isset($_SESSION['user'])): ?>
                    <!-- User badge mobile dengan warna berbeda -->
                    <div class="px-3 py-1 rounded-full mr-3 <?=
                                                            $_SESSION['user']['username'] === 'admin' ? 'bg-purple-500/20' : ($_SESSION['user']['role'] === 'admin' ? 'bg-blue-500/20' : 'bg-green-400/20')
                                                            ?>">
                        <i class="bi bi-person-circle"></i>
                    </div>
                <?php endif; ?>

                <button id="mobile-menu-button" class="text-white focus:outline-none">
                    <i class="bi bi-list text-2xl"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu (Hidden by default) -->
        <div id="mobile-menu" class="md:hidden hidden pt-4 pb-3 border-t border-white/20">
            <?php if (isset($_SESSION['user'])): ?>
                <!-- User Info Mobile -->
                <div class="px-4 py-3 bg-white/10 rounded-lg mb-3">
                    <div class="flex items-center">
                        <div class="bg-white/20 p-2 rounded-full mr-3">
                            <i class="bi bi-person-circle"></i>
                        </div>
                        <div>
                            <p class="font-medium"><?= htmlspecialchars($_SESSION['user']['username']) ?></p>
                            <p class="text-white/80 text-sm"><?= $_SESSION['user']['email'] ?></p>
                            <span class="inline-block mt-1 px-2 py-0.5 rounded-full text-xs <?=
                                                                                            $_SESSION['user']['username'] === 'admin' ? 'bg-purple-500' : ($_SESSION['user']['role'] === 'admin' ? 'bg-blue-500' : 'bg-green-500')
                                                                                            ?>">
                                <?= $_SESSION['user']['role'] ?>
                                <?= $_SESSION['user']['username'] === 'admin' ? ' (SuperAdmin)' : '' ?>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Menu Items Mobile -->
                <div class="space-y-2">
                    <!-- Menu untuk SuperAdmin -->
                    <?php if ($_SESSION['user']['username'] === 'admin'): ?>
                        <a href="index.php?url=karyawan"
                            class="flex items-center px-4 py-3 rounded-lg <?= ($_GET['url'] ?? '') == 'karyawan' ? 'bg-white/20' : 'hover:bg-white/10' ?> transition">
                            <i class="bi bi-people mr-3"></i>
                            Kelola Karyawan
                        </a>
                        <a href="index.php?url=admin&action=create"
                            class="flex items-center px-4 py-3 rounded-lg <?= ($_GET['url'] ?? '') == 'admin' ? 'bg-white/20' : 'hover:bg-white/10' ?> transition">
                            <i class="bi bi-person-plus-fill mr-3"></i>
                            Tambah Admin Baru
                        </a>
                        <a href="index.php?url=activity-log"
                            class="flex items-center px-4 py-3 rounded-lg <?= ($_GET['url'] ?? '') == 'activity-log' ? 'bg-white/20' : 'hover:bg-white/10' ?> transition">
                            <i class="bi bi-activity mr-1"></i>
                            Activity Log
                        </a>
                        <a href="index.php?url=karyawan&action=trash"
                            class="flex items-center px-4 py-3 rounded-lg <?= ($_GET['action'] ?? '') == 'trash' ? 'bg-white/20' : 'hover:bg-white/10' ?> transition">
                            <i class="bi bi-trash3 mr-3"></i>
                            Tong Sampah
                        </a>

                        <!-- Menu untuk Admin biasa -->
                    <?php elseif ($_SESSION['user']['role'] === 'admin'): ?>
                        <a href="index.php?url=karyawan"
                            class="flex items-center px-4 py-3 rounded-lg <?= ($_GET['url'] ?? '') == 'karyawan' ? 'bg-white/20' : 'hover:bg-white/10' ?> transition">
                            <i class="bi bi-house-door mr-3"></i>
                            Dashboard Karyawan
                        </a>
                        <a href="index.php?url=karyawan&action=create"
                            class="flex items-center px-4 py-3 rounded-lg <?= ($_GET['action'] ?? '') == 'create' ? 'bg-white/20' : 'hover:bg-white/10' ?> transition">
                            <i class="bi bi-person-plus mr-3"></i>
                            Tambah Karyawan
                        </a>

                        <!-- Menu untuk User biasa -->
                    <?php else: ?>
                        <a href="index.php?url=auth&action=dashboard"
                            class="flex items-center px-4 py-3 rounded-lg <?= ($_GET['url'] ?? '') == 'auth' ? 'bg-white/20' : 'hover:bg-white/10' ?> transition">
                            <i class="bi bi-speedometer2 mr-3"></i>
                            Dashboard User
                        </a>
                    <?php endif; ?>

                    <!-- Date Mobile -->
                    <div class="px-4 py-3 text-white/80">
                        <i class="bi bi-calendar3 mr-2"></i>
                        <?= date('d F Y') ?>
                    </div>

                    <!-- Logout Mobile -->
                    <a href="index.php?url=auth&action=logout"
                        class="flex items-center px-4 py-3 rounded-lg bg-red-500/20 hover:bg-red-500/30 transition mt-4">
                        <i class="bi bi-box-arrow-right mr-3"></i>
                        Logout
                    </a>
                </div>

            <?php else: ?>
                <!-- Login Menu Mobile -->
                <div class="space-y-2">
                    <div class="px-4 py-3 text-white/80">
                        <i class="bi bi-calendar3 mr-2"></i>
                        <?= date('d F Y') ?>
                    </div>

                    <a href="index.php?url=auth&action=login"
                        class="flex items-center px-4 py-3 rounded-lg bg-white/20 hover:bg-white/30 transition">
                        <i class="bi bi-box-arrow-in-right mr-3"></i>
                        Login sebagai Admin
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</nav>

<!-- JavaScript for Mobile Menu -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        if (mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                // Toggle class hidden
                mobileMenu.classList.toggle('hidden');

                // Ganti icon
                const icon = mobileMenuButton.querySelector('i');
                if (mobileMenu.classList.contains('hidden')) {
                    icon.classList.remove('bi-x');
                    icon.classList.add('bi-list');
                } else {
                    icon.classList.remove('bi-list');
                    icon.classList.add('bi-x');
                }
            });
        }
    });
</script>