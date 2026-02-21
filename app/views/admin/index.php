<div class="mb-8">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
        <div class="mb-4 md:mb-0">
            <h1 class="text-3xl font-bold text-gray-800"><?= $judul ?? 'Daftar Admin' ?></h1>
            <p class="text-gray-600 mt-2">Kelola akun admin yang dapat mengakses sistem</p>
        </div>
        <a href="index.php?url=admin&action=create"
            class="bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-4 rounded-lg shadow hover:shadow-md transition-all duration-200 inline-flex items-center">
            <i class="bi bi-person-plus-fill mr-2"></i>
            Tambah Admin
        </a>
    </div>

    <!-- Success/Error Messages -->
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

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="joko-alert joko-alert-danger mb-6 animate-fade-in">
            <div class="flex items-start">
                <i class="bi bi-exclamation-triangle text-xl mr-3 mt-0.5"></i>
                <div>
                    <p class="font-bold"><?= htmlspecialchars($_SESSION['error']) ?></p>
                </div>
            </div>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if (empty($admins)): ?>
        <!-- Empty State -->
        <div class="joko-card text-white p-8 text-center rounded-xl shadow-lg">
            <div class="mb-6">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-white/20 rounded-full mb-4">
                    <i class="bi bi-person-badge text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold mb-2">Belum Ada Data Admin</h3>
                <p class="opacity-90 mb-6">Mulai dengan menambahkan admin pertama Anda</p>
                <a href="index.php?url=admin&action=create"
                    class="joko-btn joko-btn-light inline-flex items-center">
                    <i class="bi bi-plus-lg mr-2"></i>
                    Tambah Admin Pertama
                </a>
            </div>
        </div>
    <?php else: ?>
        <!-- Stats Card -->
        <div class="bg-white rounded-xl card-shadow p-6 mb-8 border-l-4 border-purple-500">
            <div class="flex items-center">
                <div class="bg-purple-100 p-3 rounded-lg mr-4">
                    <i class="bi bi-people-fill text-purple-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Total Admin</p>
                    <p class="text-2xl font-bold text-gray-800"><?= count($admins) ?></p>
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="bg-white rounded-xl card-shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <i class="bi bi-hash mr-1"></i> ID
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <i class="bi bi-person mr-1"></i> Username
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <i class="bi bi-envelope mr-1"></i> Email
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <i class="bi bi-calendar3 mr-1"></i> Tanggal Dibuat
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <i class="bi bi-gear mr-1"></i> Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($admins as $admin): ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                        #<?= $admin['id'] ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-r from-blue-400 to-purple-500 rounded-full flex items-center justify-center text-white font-bold">
                                            <?= strtoupper(substr($admin['username'], 0, 1)) ?>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                <?= htmlspecialchars($admin['username']) ?>
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                Role: <?= htmlspecialchars($admin['role']) ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        <?= htmlspecialchars($admin['email']) ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="flex items-center">
                                        <i class="bi bi-calendar3 text-gray-400 mr-2"></i>
                                        <?= date('d-m-Y', strtotime($admin['created_at'])) ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="<?= url('/?url=admin&action=edit&id=' . $admin['id']) ?>"
                                            class="joko-btn joko-btn-warning joko-btn-sm inline-flex items-center">
                                            <i class="bi bi-pencil mr-1"></i>
                                            Edit
                                        </a>
                                        <a href="<?= url('/?url=admin&action=delete&id=' . $admin['id']) ?>"
                                            class="joko-btn joko-btn-danger joko-btn-sm inline-flex items-center"
                                            onclick="return confirmDelete('<?= htmlspecialchars($k['nama']) ?>')">
                                            <i class="bi bi-trash mr-1"></i>
                                            Hapus
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Table Footer -->
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                <div class="text-sm text-gray-600">
                    <i class="bi bi-info-circle mr-1"></i>
                    Menampilkan <span class="font-bold"><?= count($admins) ?></span> data admin
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
    function confirmDeleteAdmin(username, id) {
        if (confirm(`Apakah Anda yakin ingin menghapus admin "${username}"?`)) {
            // Untuk sekarang, tampilkan alert
            alert('Fitur hapus admin akan segera tersedia!');
            // Nanti bisa diimplementasikan dengan:
            // window.location.href = `index.php?url=admin&action=delete&id=${id}`;
        }
    }
</script>