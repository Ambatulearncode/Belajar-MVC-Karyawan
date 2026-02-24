<div class="mb-8">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
        <div class="mb-4 md:mb-0">
            <h1 class="text-3xl font-bold text-gray-800"><?= $judul ?? 'Activity Log' ?></h1>
            <p class="text-gray-600 mt-2">Catatan aktivitas sistem (Hanya untuk SuperAdmin)</p>
        </div>
        <div class="flex space-x-3">
            <a href="?url=activity-log&action=clear"
                onclick="return confirm('Apakah Anda yakin ingin membersihkan log yang lebih dari 30 hari?')"
                class="bg-orange-600 hover:bg-orange-700 text-white font-medium py-2 px-4 rounded-lg shadow hover:shadow-md transition-all duration-200 inline-flex items-center">
                <i class="bi bi-trash mr-2"></i>
                Bersihkan Log Lama
            </a>
            <a href="index.php?url=admin"
                class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg shadow hover:shadow-md transition-all duration-200 inline-flex items-center">
                <i class="bi bi-arrow-left mr-2"></i>
                Kembali ke Admin
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Total Logs -->
        <div class="bg-white rounded-xl card-shadow p-6 border-l-4 border-blue-500">
            <div class="flex items-center">
                <div class="bg-blue-100 p-3 rounded-lg mr-4">
                    <i class="bi bi-activity text-blue-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Total Aktivitas</p>
                    <p class="text-2xl font-bold text-gray-800"><?= $totalItems ?></p>
                </div>
            </div>
        </div>

        <!-- Today's Activities -->
        <div class="bg-white rounded-xl card-shadow p-6 border-l-4 border-green-500">
            <div class="flex items-center">
                <div class="bg-green-100 p-3 rounded-lg mr-4">
                    <i class="bi bi-calendar-day text-green-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Hari Ini</p>
                    <p class="text-2xl font-bold text-gray-800"><?= $todayCount ?></p>
                </div>
            </div>
        </div>

        <!-- Unique Users -->
        <div class="bg-white rounded-xl card-shadow p-6 border-l-4 border-purple-500">
            <div class="flex items-center">
                <div class="bg-purple-100 p-3 rounded-lg mr-4">
                    <i class="bi bi-people text-purple-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Pengguna Aktif</p>
                    <p class="text-2xl font-bold text-gray-800"><?= $activeUserCount ?></p>
                </div>
            </div>
        </div>

        <!-- System Status -->
        <div class="bg-white rounded-xl card-shadow p-6 border-l-4 border-yellow-500">
            <div class="flex items-center">
                <div class="bg-yellow-100 p-3 rounded-lg mr-4">
                    <i class="bi bi-shield-check text-yellow-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Status Sistem</p>
                    <p class="text-2xl font-bold text-gray-800 text-green-600">Aktif</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Activity Log Table -->
    <div class="bg-white rounded-xl card-shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <i class="bi bi-clock mr-1"></i> Waktu
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <i class="bi bi-person mr-1"></i> Pengguna
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <i class="bi bi-activity mr-1"></i> Aksi
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <i class="bi bi-info-circle mr-1"></i> Deskripsi
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <i class="bi bi-pc-display mr-1"></i> Info Sistem
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if (empty($logs)): ?>
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <i class="bi bi-activity text-4xl text-gray-300 mb-3"></i>
                                    <p class="text-lg font-medium">Belum ada aktivitas yang tercatat</p>
                                    <p class="text-gray-600">Aktivitas akan muncul di sini setelah ada aksi di sistem</p>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($logs as $log): ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 font-medium">
                                        <?= date('d-m-Y', strtotime($log['created_at'])) ?>
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        <?= date('H:i:s', strtotime($log['created_at'])) ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-r from-blue-400 to-purple-500 rounded-full flex items-center justify-center text-white font-bold">
                                            <?= strtoupper(substr($log['username'], 0, 1)) ?>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                <?= htmlspecialchars($log['email']) ?>
                                            </div>
                                            <span class="inline-block mt-1 px-2 py-0.5 rounded-full text-xs <?=
                                                                                                            $log['role'] === 'superadmin' ? 'bg-purple-100 text-purple-800' : ($log['role'] === 'admin' ? 'bg-blue-100 text-blue-800' :
                                                                                                                'bg-gray-100 text-gray-800') ?>">
                                                <?= htmlspecialchars($log['role']) ?>
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium <?= get_activity_color($log['action']) ?>">
                                        <i class="bi <?= get_activity_icon($log['action']) ?> mr-1"></i>
                                        <?= ucfirst(htmlspecialchars($log['action'])) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        <?= htmlspecialchars($log['description']) ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="space-y-1">
                                        <div class="flex items-center">
                                            <i class="bi bi-globe text-gray-400 mr-2"></i>
                                            <span class="font-mono text-xs"><?= htmlspecialchars($log['ip_address'] ?? 'N/A') ?></span>
                                        </div>
                                        <div class="text-xs text-gray-400 truncate max-w-xs" title="<?= htmlspecialchars($log['user_agent'] ?? '') ?>">
                                            <?= substr(htmlspecialchars($log['user_agent'] ?? 'N/A'), 0, 50) ?>...
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if ($totalPages > 1): ?>
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="text-sm text-gray-600 mb-2 md:mb-0">
                        <i class="bi bi-info-circle mr-1"></i>
                        Menampilkan
                        <span class="font-bold">
                            <?= (($currentPage - 1) * $perPage + 1) ?> -
                            <?= min($currentPage * $perPage, $totalItems) ?>
                        </span>
                        dari <span class="font-bold"><?= $totalItems ?></span> aktivitas
                    </div>

                    <div class="flex items-center space-x-1">
                        <!-- Previous Button -->
                        <a href="?url=activity-log&page=<?= max(1, $currentPage - 1) ?>"
                            class="px-3 py-1.5 rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-colors duration-200 <?= $currentPage == 1 ? 'opacity-50 cursor-not-allowed' : '' ?>"
                            <?= $currentPage == 1 ? 'onclick="return false;"' : '' ?>>
                            <i class="bi bi-chevron-left"></i>
                        </a>

                        <!-- Page Numbers -->
                        <?php
                        $startPage = max(1, $currentPage - 2);
                        $endPage = min($totalPages, $currentPage + 2);

                        if ($startPage > 1): ?>
                            <a href="?url=activity-log&page=1"
                                class="px-3 py-1.5 rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-colors duration-200">
                                1
                            </a>
                            <?php if ($startPage > 2): ?>
                                <span class="px-2 text-gray-400">...</span>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php for ($page = $startPage; $page <= $endPage; $page++): ?>
                            <a href="?url=activity-log&page=<?= $page ?>"
                                class="px-3 py-1.5 rounded-lg border transition-colors duration-200 font-medium
                        <?= $page == $currentPage
                                ? 'bg-blue-600 border-blue-600 text-white hover:bg-blue-700'
                                : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-50 hover:border-gray-400' ?>">
                                <?= $page ?>
                            </a>
                        <?php endfor; ?>

                        <?php if ($endPage < $totalPages): ?>
                            <?php if ($endPage < $totalPages - 1): ?>
                                <span class="px-2 text-gray-400">...</span>
                            <?php endif; ?>
                            <a href="?url=activity-log&page=<?= $totalPages ?>"
                                class="px-3 py-1.5 rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-colors duration-200">
                                <?= $totalPages ?>
                            </a>
                        <?php endif; ?>

                        <!-- Next Button -->
                        <a href="?url=activity-log&page=<?= min($totalPages, $currentPage + 1) ?>"
                            class="px-3 py-1.5 rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-colors duration-200 <?= $currentPage == $totalPages ? 'opacity-50 cursor-not-allowed' : '' ?>"
                            <?= $currentPage == $totalPages ? 'onclick="return false;"' : '' ?>>
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Recent Activities Sidebar -->
    <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Activities -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl card-shadow p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <i class="bi bi-clock-history mr-2"></i>
                    Aktivitas Terbaru
                </h3>
                <div class="space-y-4">
                    <?php if (empty($recentActivities)): ?>
                        <p class="text-gray-500 text-center py-4">Belum ada aktivitas terbaru</p>
                    <?php else: ?>
                        <?php foreach ($recentActivities as $activity): ?>
                            <div class="flex items-start space-x-3 p-3 rounded-lg hover:bg-gray-50 transition">
                                <div class="flex-shrink-0">
                                    <div class="h-10 w-10 rounded-full flex items-center justify-center <?= get_activity_color($activity['action']) ?>">
                                        <i class="bi <?= get_activity_icon($activity['action']) ?>"></i>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900">
                                        <?= htmlspecialchars($activity['username']) ?>
                                        <span class="text-gray-600">• <?= htmlspecialchars($activity['description']) ?></span>
                                    </p>
                                    <div class="flex items-center mt-1">
                                        <span class="text-xs text-gray-500">
                                            <?= date('d-m-Y H:i', strtotime($activity['created_at'])) ?>
                                        </span>
                                        <span class="mx-2 text-gray-300">•</span>
                                        <span class="text-xs px-2 py-0.5 rounded-full <?=
                                                                                        $activity['role'] === 'superadmin' ? 'bg-purple-100 text-purple-800' : ($activity['role'] === 'admin' ? 'bg-blue-100 text-blue-800' :
                                                                                            'bg-gray-100 text-gray-800') ?>">
                                            <?= htmlspecialchars($activity['role']) ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Activity Stats -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl card-shadow p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <i class="bi bi-bar-chart mr-2"></i>
                    Statistik Aktivitas
                </h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Login</span>
                        <span class="text-sm font-medium text-gray-900"><?= $statistics['login'] ?></span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Tambah Data</span>
                        <span class="text-sm font-medium text-gray-900"><?= $statistics['create'] ?></span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Edit Data</span>
                        <span class="text-sm font-medium text-gray-900"><?= $statistics['update'] ?></span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Hapus Data</span>
                        <span class="text-sm font-medium text-gray-900"><?= $statistics['delete'] ?></span>
                    </div>
                    <div class="pt-4 border-t border-gray-200">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-900">Total</span>
                            <span class="text-sm font-bold text-blue-600"><?= $totalItems ?> aktivitas</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>