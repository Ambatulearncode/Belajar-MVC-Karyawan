<div class="mb-8">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
        <div class="mb-4 md:mb-0">
            <h1 class="text-3xl font-bold text-gray-800"><?= $judul ?? 'Daftar Karyawan' ?></h1>
            <p class="text-gray-600 mt-2">Kelola data karyawan perusahaan dengan mudah</p>
        </div>
        <a href="index.php?url=karyawan&action=create"
            class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg shadow hover:shadow-md transition-all duration-200 inline-flex items-center">
            <i class="bi bi-plus-circle mr-2"></i>
            Tambah Karyawan
        </a>
    </div>
    <?php
    // CEK KONDISI
    $databaseKosong = ($totalSemuaKaryawan == 0); // Emang gak ada data sama sekali
    $pencarianKosong = (empty($karyawan) && $totalSemuaKaryawan > 0); // Pencarian gak ketemu
    ?>
    <?php if ($databaseKosong) : ?>
        <!-- Empty State -->
        <div class="bg-blue-50 border border-blue-200 p-8 text-center rounded-xl shadow-lg">
            <div class="mb-6">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-blue-100 rounded-full mb-4">
                    <i class="bi bi-people text-3xl text-blue-600"></i>
                </div>
                <h3 class="text-2xl font-bold mb-2 text-gray-800">Belum Ada Data Karyawan</h3>
                <p class="text-gray-600 mb-6">Mulai dengan menambahkan data karyawan pertama Anda</p>
                <a href="<?= url('/?url=karyawan&action=create') ?>"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow inline-flex items-center">
                    <i class="bi bi-plus-lg mr-2"></i>
                    Tambah Data Pertama
                </a>
            </div>
        </div>

    <?php elseif ($pencarianKosong): ?>
        <!-- KONDISI 2: PENCARIAN TIDAK DITEMUKAN -->
        <div class="bg-blue-50 border border-blue-200 p-8 text-center rounded-xl shadow-lg">
            <div class="mb-6">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-blue-100 rounded-full mb-4">
                    <i class="bi bi-search text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold mb-2 text-gray-800">Data Tidak Ditemukan</h3>
                <p class="text-gray-600 mb-4">
                    Pencarian untuk
                    <span class="font-semibold text-blue-700">"<?= htmlspecialchars($search ?? '') ?>"</span>
                    <?php if (!empty($selectedJabatan) && $selectedJabatan !== 'all'): ?>
                        dengan jabatan
                        <span class="font-semibold text-blue-700">"<?= htmlspecialchars($selectedJabatan) ?>"</span>
                    <?php endif; ?>
                    tidak ditemukan.
                </p>
                <!-- Tombol Reset Filter -->
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="?url=karyawan&page=1"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg shadow inline-flex items-center justify-center">
                        <i class="bi bi-arrow-repeat mr-2"></i>
                        Reset Semua Filter
                    </a>
                    <a href="<?= url('/?url=karyawan&action=create') ?>"
                        class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-6 rounded-lg shadow inline-flex items-center justify-center">
                        <i class="bi bi-plus-lg mr-2"></i>
                        Tambah Karyawan Baru
                    </a>
                </div>
            </div>
        </div>
    <?php else: ?>


        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Total Karyawan -->
            <div class="bg-white rounded-xl card-shadow p-6 border-l-4 border-blue-500">
                <div class="flex items-center">
                    <div class="bg-blue-100 p-3 rounded-lg mr-4">
                        <i class="bi bi-people text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Total Karyawan</p>
                        <p class="text-2xl font-bold text-gray-800"><?= $totalItems ?? count($karyawan) ?></p>
                    </div>
                </div>
            </div>

            <!-- Total Gaji -->
            <div class="bg-white rounded-xl card-shadow p-6 border-l-4 border-green-500">
                <div class="flex items-center">
                    <div class="bg-green-100 p-3 rounded-lg mr-4">
                        <i class="bi bi-cash-coin text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Total Gaji Bulanan</p>
                        <p class="text-2xl font-bold text-gray-800">
                            Rp <?= isset($karyawanModel) ?
                                    number_format($karyawanModel->getTotalSalary(), 0, ',', '.') :
                                    number_format(array_sum(array_column($karyawan, 'gaji')), 0, ',', '.') ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Rata-rata Gaji -->
            <div class="bg-white rounded-xl card-shadow p-6 border-l-4 border-purple-500">
                <div class="flex items-center">
                    <div class="bg-purple-100 p-3 rounded-lg mr-4">
                        <i class="bi bi-graph-up text-purple-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Rata-rata Gaji</p>
                        <p class="text-2xl font-bold text-gray-800">
                            Rp <?= isset($karyawanModel) ?
                                    number_format($karyawanModel->getAverageSalary(), 0, ',', '.') :
                                    number_format(array_sum(array_column($karyawan, 'gaji')) / count($karyawan), 0, ',', '.') ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search and Filter Section -->
        <div class="bg-white rounded-xl card-shadow p-6 mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <!-- Search Form -->
                <div class="flex-1">
                    <form method="GET" action="" class="flex gap-2">
                        <input type="hidden" name="url" value="karyawan">
                        <input type="hidden" name="page" value="1">

                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="bi bi-search text-gray-400"></i>
                            </div>
                            <input type="text"
                                name="search"
                                value="<?= htmlspecialchars($search ?? '') ?>"
                                placeholder="Cari nama atau NIK..."
                                class="pl-10 pr-4 py-2.5 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition">
                        </div>

                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg font-medium inline-flex items-center transition">
                            <i class="bi bi-search mr-2"></i>
                            Cari
                        </button>

                        <?php if (!empty($search) || !empty($selectedJabatan)): ?>
                            <a href="?url=karyawan&page=1"
                                class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2.5 rounded-lg font-medium inline-flex items-center transition">
                                <i class="bi bi-x-circle mr-2"></i>
                                Reset
                            </a>
                        <?php endif; ?>
                    </form>
                </div>

                <!-- Filter by Jabatan -->
                <div class="md:w-64">
                    <form method="GET" action="" class="flex gap-2">
                        <input type="hidden" name="url" value="karyawan">
                        <input type="hidden" name="page" value="1">
                        <?php if (!empty($search)): ?>
                            <input type="hidden" name="search" value="<?= htmlspecialchars($search) ?>">
                        <?php endif; ?>

                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="bi bi-filter text-gray-400"></i>
                            </div>
                            <select name="jabatan"
                                onchange="this.form.submit()"
                                class="pl-10 pr-4 py-2.5 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none appearance-none bg-white cursor-pointer transition">
                                <option value="all" <?= empty($selectedJabatan) || $selectedJabatan === 'all' ? 'selected' : '' ?>>Semua Jabatan</option>
                                <?php foreach ($allJabatans as $j): ?>
                                    <option value="<?= htmlspecialchars($j) ?>"
                                        <?= $selectedJabatan === $j ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($j) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <i class="bi bi-chevron-down text-gray-400"></i>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Active Filters Badges -->
            <?php if (!empty($search) || (!empty($selectedJabatan) && $selectedJabatan !== 'all')): ?>
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-600">Filter aktif:</span>
                        <?php if (!empty($search)): ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-800">
                                <i class="bi bi-search mr-1"></i>
                                "<?= htmlspecialchars($search) ?>"
                                <a href="?url=karyawan&page=1&jabatan=<?= urlencode($selectedJabatan ?? 'all') ?>"
                                    class="ml-2 text-blue-600 hover:text-blue-800">
                                    <i class="bi bi-x"></i>
                                </a>
                            </span>
                        <?php endif; ?>

                        <?php if (!empty($selectedJabatan) && $selectedJabatan !== 'all'): ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-purple-100 text-purple-800">
                                <i class="bi bi-briefcase mr-1"></i>
                                <?= htmlspecialchars($selectedJabatan) ?>
                                <a href="?url=karyawan&page=1&search=<?= urlencode($search ?? '') ?>"
                                    class="ml-2 text-purple-600 hover:text-purple-800">
                                    <i class="bi bi-x"></i>
                                </a>
                            </span>
                        <?php endif; ?>

                        <?php if (!empty($search) || (!empty($selectedJabatan) && $selectedJabatan !== 'all')): ?>
                            <a href="?url=karyawan&page=1"
                                class="text-sm text-gray-600 hover:text-gray-800 ml-2 inline-flex items-center">
                                <i class="bi bi-x-circle mr-1"></i>
                                Hapus semua filter
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Data Table -->
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
                                <i class="bi bi-calendar3 mr-1.5 text-blue-600"></i> Tanggal Masuk
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-blue-800 uppercase tracking-wider">
                                <i class="bi bi-gear mr-1.5 text-blue-600"></i> Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($karyawan as $index => $k): ?>
                            <tr class="hover:bg-gray-50 transition-colors">
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
                            <?= $k['jabatan'] == 'Manager' ? 'bg-purple-100 text-purple-800' : ($k['jabatan'] == 'Staff IT' ? 'bg-blue-100 text-blue-800' :
                                'bg-gray-100 text-gray-800') ?>">
                                        <?= htmlspecialchars($k['jabatan']) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-green-600">
                                        Rp <?= number_format($k['gaji'], 0, ',', '.') ?>
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        per bulan
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="flex items-center">
                                        <i class="bi bi-calendar3 text-gray-400 mr-2"></i>
                                        <?= date('d-m-Y', strtotime($k['tanggal_masuk'])) ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="<?= url('/?url=karyawan&action=edit&id=' . $k['id']) ?>"
                                            class="bg-green-600 hover:bg-green-700 text-white font-medium py-1.5 px-3 rounded-lg shadow hover:shadow-md transition-all duration-200 inline-flex items-center text-sm">
                                            <i class="bi bi-pencil mr-1"></i>
                                            Edit
                                        </a>
                                        <a href="?url=karyawan&action=delete&id=<?= $k['id'] ?>"
                                            data-confirm-delete
                                            data-item-name="<?= htmlspecialchars($k['nama']) ?>"
                                            class="bg-red-600 hover:bg-red-700 text-white font-medium py-1.5 px-3 rounded-lg shadow hover:shadow-md transition-all duration-200 inline-flex items-center text-sm">
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

            <!-- Table Footer with Pagination -->
            <?php if (isset($totalPages) && $totalPages > 0): ?>
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <div class="text-sm text-gray-600 mb-2 md:mb-0">
                            <i class="bi bi-info-circle mr-1"></i>
                            Menampilkan
                            <span class="font-bold">
                                <?php
                                if (isset($currentPage) && isset($perPage) && isset($totalItems)) {
                                    $start = ($currentPage - 1) * $perPage + 1;
                                    $end = min($currentPage * $perPage, $totalItems);
                                    echo $start . ' - ' . $end;
                                } else {
                                    echo '1 - ' . count($karyawan);
                                }
                                ?>
                            </span>
                            dari <span class="font-bold"><?= $totalItems ?? count($karyawan) ?></span> data karyawan
                        </div>

                        <!-- Pagination Controls -->
                        <?php if (isset($totalPages) && $totalPages > 1): ?>
                            <div class="flex items-center space-x-1">
                                <!-- Previous Button -->
                                <a href="?url=karyawan&page=<?= max(1, $currentPage - 1) ?><?= !empty($search) ? '&search=' . urlencode($search) : '' ?><?= !empty($selectedJabatan) && $selectedJabatan !== 'all' ? '&jabatan=' . urlencode($selectedJabatan) : '' ?>"
                                    class="px-3 py-1.5 rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-colors duration-200 <?= $currentPage == 1 ? 'opacity-50 cursor-not-allowed' : '' ?>"
                                    <?= $currentPage == 1 ? 'onclick="return false;"' : '' ?>>
                                    <i class="bi bi-chevron-left"></i>
                                </a>

                                <!-- Page Numbers -->
                                <?php
                                // Calculate page range to show
                                $startPage = max(1, $currentPage - 2);
                                $endPage = min($totalPages, $currentPage + 2);

                                // Show first page if not in range
                                if ($startPage > 1): ?>
                                    <a href="?url=karyawan&page=1<?= !empty($search) ? '&search=' . urlencode($search) : '' ?><?= !empty($selectedJabatan) && $selectedJabatan !== 'all' ? '&jabatan=' . urlencode($selectedJabatan) : '' ?>"
                                        class="px-3 py-1.5 rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-colors duration-200">
                                        1
                                    </a>
                                    <?php if ($startPage > 2): ?>
                                        <span class="px-2 text-gray-400">...</span>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <!-- Page numbers in range -->
                                <?php for ($page = $startPage; $page <= $endPage; $page++): ?>
                                    <a href="?url=karyawan&page=<?= $page ?><?= !empty($search) ? '&search=' . urlencode($search) : '' ?><?= !empty($selectedJabatan) && $selectedJabatan !== 'all' ? '&jabatan=' . urlencode($selectedJabatan) : '' ?>"
                                        class="px-3 py-1.5 rounded-lg border transition-colors duration-200 font-medium
                                    <?= $page == $currentPage
                                        ? 'bg-blue-600 border-blue-600 text-white hover:bg-blue-700'
                                        : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-50 hover:border-gray-400' ?>">
                                        <?= $page ?>
                                    </a>
                                <?php endfor; ?>

                                <!-- Show last page if not in range -->
                                <?php if ($endPage < $totalPages): ?>
                                    <?php if ($endPage < $totalPages - 1): ?>
                                        <span class="px-2 text-gray-400">...</span>
                                    <?php endif; ?>
                                    <a href="?url=karyawan&page=<?= $totalPages ?><?= !empty($search) ? '&search=' . urlencode($search) : '' ?><?= !empty($selectedJabatan) && $selectedJabatan !== 'all' ? '&jabatan=' . urlencode($selectedJabatan) : '' ?>"
                                        class="px-3 py-1.5 rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-colors duration-200">
                                        <?= $totalPages ?>
                                    </a>
                                <?php endif; ?>

                                <!-- Next Button -->
                                <a href="?url=karyawan&page=<?= min($totalPages, $currentPage + 1) ?><?= !empty($search) ? '&search=' . urlencode($search) : '' ?><?= !empty($selectedJabatan) && $selectedJabatan !== 'all' ? '&jabatan=' . urlencode($selectedJabatan) : '' ?>"
                                    class="px-3 py-1.5 rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-colors duration-200 <?= $currentPage == $totalPages ? 'opacity-50 cursor-not-allowed' : '' ?>"
                                    <?= $currentPage == $totalPages ? 'onclick="return false;"' : '' ?>>
                                    <i class="bi bi-chevron-right"></i>
                                </a>
                            </div>
                        <?php endif; ?>

                        <div class="text-sm text-gray-600 mt-2 md:mt-0">
                            <span class="font-semibold">Total Gaji Bulanan:</span>
                            <span class="font-bold text-green-600 ml-2">
                                Rp <?= isset($karyawanModel) ?
                                        number_format($karyawanModel->getTotalSalary(), 0, ',', '.') :
                                        number_format(array_sum(array_column($karyawan, 'gaji')), 0, ',', '.') ?>
                            </span>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>