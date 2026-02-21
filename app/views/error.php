<div class="max-w-4xl mx-auto py-12">
    <div class="text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-red-100 rounded-full mb-6">
            <i class="bi bi-exclamation-triangle text-red-600 text-2xl"></i>
        </div>
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Terjadi Kesalahan</h1>
        <p class="text-gray-600 mb-8">
            <?= $error_message ?? 'Maaf, terjadi kesalahan pada sistem.' ?>
        </p>
        <a href="<?= url('/?url=karyawan') ?>"
            class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
            <i class="bi bi-arrow-left mr-2"></i>
            Kembali ke Dashboard
        </a>
    </div>
</div>