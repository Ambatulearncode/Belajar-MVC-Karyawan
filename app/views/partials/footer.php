<!-- Footer -->
<footer class="bg-gray-800 text-white py-8">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Brand Info -->
            <div>
                <div class="flex items-center space-x-3 mb-4">
                    <div class="bg-white/10 p-2 rounded-lg">
                        <i class="bi bi-people-fill text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold">Sistem Karyawan</h3>
                </div>
                <p class="text-gray-400">
                    Aplikasi manajemen data karyawan dengan sistem MVC modern.
                </p>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="text-lg font-semibold mb-4">Menu Cepat</h4>
                <ul class="space-y-2">
                    <li>
                        <a href="<?= url('/?url=karyawan') ?>" class="text-gray-400 hover:text-white transition flex items-center">
                            <i class="bi bi-house-door mr-2"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="<?= url('/?url=karyawan&action=create') ?>" class="text-gray-400 hover:text-white transition flex items-center">
                            <i class="bi bi-person-plus mr-2"></i> Tambah Karyawan
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Tech Stack -->
            <div>
                <h4 class="text-lg font-semibold mb-4">Teknologi</h4>
                <div class="flex flex-wrap gap-2">
                    <span class="bg-blue-500/20 text-blue-300 px-3 py-1 rounded-full text-sm">
                        PHP 8+
                    </span>
                    <span class="bg-purple-500/20 text-purple-300 px-3 py-1 rounded-full text-sm">
                        MVC Pattern
                    </span>
                    <span class="bg-green-500/20 text-green-300 px-3 py-1 rounded-full text-sm">
                        Tailwind CSS
                    </span>
                    <span class="bg-yellow-500/20 text-yellow-300 px-3 py-1 rounded-full text-sm">
                        Joko UI
                    </span>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <div class="border-t border-gray-700 mt-8 pt-6 text-center text-gray-400">
            <p>
                <i class="bi bi-code-slash mr-2"></i>
                Dibuat dengan ❤️ menggunakan PHP MVC • © <?= date('Y') ?>
            </p>
            <p class="text-sm mt-2">
                <span class="bg-green-500/20 text-green-300 px-2 py-1 rounded text-xs">
                    <i class="bi bi-check-circle mr-1"></i> v1.0.0
                </span>
            </p>
        </div>
    </div>
</footer>