<!-- views/karyawan/trash.php -->
<div class="mb-8">
    <!-- Page Header - SAMA PERSIS KAYAK INDEX -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
        <div class="mb-4 md:mb-0">
            <h1 class="text-3xl font-bold text-gray-800">
                <i class="bi bi-trash3 text-yellow-600 mr-2"></i>
                Tong Sampah
            </h1>
            <p class="text-gray-600 mt-2">Data karyawan yang telah dihapus (soft delete)</p>
        </div>
        <a href="?url=karyawan"
            class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg shadow hover:shadow-md transition-all duration-200 inline-flex items-center">
            <i class="bi bi-arrow-left mr-2"></i>
            Kembali ke Daftar Aktif
        </a>
    </div>

    <!-- Stats Card - SAMA PERSIS KAYAK INDEX -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Total di Trash -->
        <div class="bg-white rounded-xl card-shadow p-6 border-l-4 border-yellow-500">
            <div class="flex items-center">
                <div class="bg-yellow-100 p-3 rounded-lg mr-4">
                    <i class="bi bi-trash3 text-yellow-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Total di Tong Sampah</p>
                    <p class="text-2xl font-bold text-gray-800"><?= $totalItems ?? 0 ?></p>
                </div>
            </div>
        </div>
        <!-- Kosongin 2 kolom sisanya biar konsisten -->
        <div class="bg-white rounded-xl card-shadow p-6 border-l-4 border-gray-200 opacity-0 md:block hidden">
            <!-- Placeholder biar layoutnya tetap 3 kolom -->
        </div>
        <div class="bg-white rounded-xl card-shadow p-6 border-l-4 border-gray-200 opacity-0 md:block hidden">
            <!-- Placeholder biar layoutnya tetap 3 kolom -->
        </div>
    </div>

    <!-- Search Box - SAMA PERSIS KAYAK INDEX -->
    <div class="bg-white rounded-xl card-shadow p-6 mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex-1">
                <form method="GET" action="" class="flex gap-2">
                    <input type="hidden" name="url" value="karyawan">
                    <input type="hidden" name="action" value="trash">
                    <input type="hidden" name="page" value="1">

                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="bi bi-search text-gray-400"></i>
                        </div>
                        <input type="text"
                            name="search"
                            value="<?= htmlspecialchars($search ?? '') ?>"
                            placeholder="Cari nama atau NIK karyawan yang dihapus..."
                            class="pl-10 pr-4 py-2.5 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition">
                    </div>

                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg font-medium inline-flex items-center transition">
                        <i class="bi bi-search mr-2"></i>
                        Cari
                    </button>

                    <?php if (!empty($search)): ?>
                        <a href="?url=karyawan&action=trash&page=1"
                            class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2.5 rounded-lg font-medium inline-flex items-center transition">
                            <i class="bi bi-x-circle mr-2"></i>
                            Reset
                        </a>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>

    <!-- Data Table - SAMA PERSIS KAYAK INDEX -->
    <div class="bg-white rounded-xl card-shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 table-zebra">
                <thead class="bg-blue-50 border-b-2 border-blue-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-bold text-blue-800 uppercase tracking-wider">
                            <i class="bi bi-hash mr-1.5 text-blue-600"></i> NIK
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-blue-800 uppercase tracking-wider">
                            <i class="bi bi-person mr-1.5 text-blue-600"></i> Nama
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-blue-800 uppercase tracking-wider">
                            <i class="bi bi-briefcase mr-1.5 text-blue-600"></i> Jabatan
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-blue-800 uppercase tracking-wider">
                            <i class="bi bi-cash-coin mr-1.5 text-blue-600"></i> Gaji
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-blue-800 uppercase tracking-wider">
                            <i class="bi bi-calendar3 mr-1.5 text-blue-600"></i> Dihapus Pada
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-blue-800 uppercase tracking-wider">
                            <i class="bi bi-person mr-1.5 text-blue-600"></i> Dihapus Oleh
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-blue-800 uppercase tracking-wider">
                            <i class="bi bi-gear mr-1.5 text-blue-600"></i> Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if (empty($karyawan)): ?>
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <i class="bi bi-inbox text-4xl block mb-3"></i>
                                <p class="text-lg font-medium">Tong sampah kosong</p>
                                <p class="text-sm">Tidak ada data karyawan yang dihapus</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($karyawan as $index => $k): ?>
                            <tr class="hover:bg-gray-50 transition-colors <?= $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' ?>">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                        #<?= $k['nik'] ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-r from-blue-400 to-purple-500 rounded-full flex items-center justify-center text-white font-bold">
                                            <?= strtoupper(substr($k['nama'], 0, 1)) ?>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                <?= htmlspecialchars($k['nama']) ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        <?= $k['jabatan'] == 'Manager' ? 'bg-purple-100 text-purple-800' : ($k['jabatan'] == 'Staff IT' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') ?>">
                                        <?= htmlspecialchars($k['jabatan']) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-green-600">
                                        Rp <?= number_format($k['gaji'], 0, ',', '.') ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="flex items-center">
                                        <i class="bi bi-calendar3 text-gray-400 mr-2"></i>
                                        <?= date('d-m-Y H:i', strtotime($k['deleted_at'])) ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 bg-gray-100 rounded text-sm">
                                        <i class="bi bi-person-circle mr-1 text-gray-600"></i>
                                        <?= htmlspecialchars($k['deleted_by_username'] ?? 'Unknown') ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <form method="POST"
                                            action="?url=karyawan&action=restore&id=<?= $k['id'] ?>"
                                            onsubmit="event.preventDefault(); 
                                            if(window.formHandler) {
                                                window.formHandler.showRestoreConfirmation(
                                                    '<?= htmlspecialchars($k['nama']) ?>', 
                                                    () => this.submit()
                                                ); 
                                            }">
                                            <button type="submit"
                                                class="bg-green-600 hover:bg-green-700 text-white font-medium py-1.5 px-3 rounded-lg shadow hover:shadow-md transition-all duration-200 inline-flex items-center text-sm">
                                                <i class="bi bi-arrow-return-left mr-1"></i>
                                                Restore
                                            </button>
                                        </form>

                                        <!-- Hard Delete - tetep pake showDeleteConfirmation -->
                                        <form method="POST"
                                            action="?url=karyawan&action=hard-delete&id=<?= $k['id'] ?>"
                                            onsubmit="event.preventDefault(); 
                                            if(window.formHandler) {
                                                window.formHandler.showDeleteConfirmation(
                                                    'PERMANEN: <?= htmlspecialchars($k['nama']) ?>', 
                                                    () => this.submit()
                                                ); 
                                            }">
                                            <button type="submit"
                                                class="bg-red-600 hover:bg-red-700 text-white font-medium py-1.5 px-3 rounded-lg shadow hover:shadow-md transition-all duration-200 inline-flex items-center text-sm">
                                                <i class="bi bi-trash3 mr-1"></i>
                                                Hapus Permanen
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Table Footer with Pagination - SAMA PERSIS KAYAK INDEX -->
        <?php if (isset($totalPages) && $totalPages > 0): ?>
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="text-sm text-gray-600 mb-2 md:mb-0">
                        <i class="bi bi-info-circle mr-1"></i>
                        Menampilkan
                        <span class="font-bold">
                            <?php
                            $start = ($currentPage - 1) * $perPage + 1;
                            $end = min($currentPage * $perPage, $totalItems);
                            echo $start . ' - ' . $end;
                            ?>
                        </span>
                        dari <span class="font-bold"><?= $totalItems ?></span> data di tong sampah
                    </div>

                    <?php if (isset($totalPages) && $totalPages > 1): ?>
                        <div class="flex items-center space-x-1">
                            <!-- Previous Button -->
                            <a href="?url=karyawan&action=trash&page=<?= max(1, $currentPage - 1) ?><?= !empty($search) ? '&search=' . urlencode($search) : '' ?>"
                                class="px-3 py-1.5 rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-colors duration-200 <?= $currentPage == 1 ? 'opacity-50 cursor-not-allowed' : '' ?>"
                                <?= $currentPage == 1 ? 'onclick="return false;"' : '' ?>>
                                <i class="bi bi-chevron-left"></i>
                            </a>

                            <?php
                            $startPage = max(1, $currentPage - 2);
                            $endPage = min($totalPages, $currentPage + 2);

                            if ($startPage > 1): ?>
                                <a href="?url=karyawan&action=trash&page=1<?= !empty($search) ? '&search=' . urlencode($search) : '' ?>"
                                    class="px-3 py-1.5 rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-colors duration-200">
                                    1
                                </a>
                                <?php if ($startPage > 2): ?>
                                    <span class="px-2 text-gray-400">...</span>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php for ($page = $startPage; $page <= $endPage; $page++): ?>
                                <a href="?url=karyawan&action=trash&page=<?= $page ?><?= !empty($search) ? '&search=' . urlencode($search) : '' ?>"
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
                                <a href="?url=karyawan&action=trash&page=<?= $totalPages ?><?= !empty($search) ? '&search=' . urlencode($search) : '' ?>"
                                    class="px-3 py-1.5 rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-colors duration-200">
                                    <?= $totalPages ?>
                                </a>
                            <?php endif; ?>

                            <!-- Next Button -->
                            <a href="?url=karyawan&action=trash&page=<?= min($totalPages, $currentPage + 1) ?><?= !empty($search) ? '&search=' . urlencode($search) : '' ?>"
                                class="px-3 py-1.5 rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-colors duration-200 <?= $currentPage == $totalPages ? 'opacity-50 cursor-not-allowed' : '' ?>"
                                <?= $currentPage == $totalPages ? 'onclick="return false;"' : '' ?>>
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>