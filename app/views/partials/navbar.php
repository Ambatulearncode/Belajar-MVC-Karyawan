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
                    <a href="<?= url('/?url=karyawan') ?>" class="text-xl font-bold hover:opacity-90 transition">
                        Sistem Karyawan
                    </a>
                    <p class="text-white/80 text-sm">Manajemen Data Karyawan</p>
                </div>
            </div>

            <!-- Date & Actions -->
            <div class="flex items-center space-x-4">
                <div class="hidden md:flex items-center space-x-2">
                    <a href="<?= url('/?url=karyawan') ?>"
                        class="px-4 py-2 rounded-lg <?= ($_GET['url'] ?? '') == 'karyawan' && ($_GET['action'] ?? 'index') == 'index' ? 'bg-white/20' : 'hover:bg-white/10' ?> transition">
                        <i class="bi bi-house-door mr-2"></i> Dashboard
                    </a>
                    <a href="<?= url('/?url=karyawan&action=create') ?>"
                        class="px-4 py-2 rounded-lg <?= ($_GET['action'] ?? '') == 'create' ? 'bg-white/20' : 'hover:bg-white/10' ?> transition">
                        <i class="bi bi-person-plus mr-2"></i> Tambah
                    </a>
                </div>

                <div class="bg-white/20 px-4 py-2 rounded-full">
                    <i class="bi bi-calendar3 mr-2"></i>
                    <?= date('d F Y') ?>
                </div>
            </div>
        </div>
    </div>
</nav>