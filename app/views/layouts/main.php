<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <title><?= $title ?? 'Sistem Karyawan' ?></title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Joko UI CSS -->
    <link href="https://cdn.jsdelivr.net/npm/joko-ui@latest/dist/joko-ui.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Custom Styles -->
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .hover-lift:hover {
            transform: translateY(-2px);
            transition: transform 0.2s ease;
        }

        .card-shadow {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        /* Better mobile touch targets */
        @media (max-width: 640px) {

            button,
            a.btn,
            input[type="submit"] {
                min-height: 44px;
                min-width: 44px;
            }

            /* Improve table readability on mobile */
            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            /* Better spacing for mobile */
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }
        }

        /* Smooth transitions */
        .transition-all {
            transition: all 0.3s ease;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen">
    <div class="flex flex-col min-h-screen">
        <!-- Navbar -->
        <?php include __DIR__ . '/../partials/navbar.php'; ?>

        <!-- Main Content -->
        <main class="flex-grow py-4 md:py-8">
            <div class="container mx-auto px-3 md:px-4">
                <?php
                $viewFile = __DIR__ . "/../{$view}.php";
                if (file_exists($viewFile)) {
                    include $viewFile;
                } else {
                    // Fallback error view
                ?>
                    <div class="max-w-4xl mx-auto py-12">
                        <div class="text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 bg-red-100 rounded-full mb-6">
                                <i class="bi bi-exclamation-triangle text-red-600 text-2xl"></i>
                            </div>
                            <h1 class="text-3xl font-bold text-gray-800 mb-4">Halaman Tidak Ditemukan</h1>
                            <p class="text-gray-600 mb-8">
                                File view "<?= htmlspecialchars($view) ?>.php" tidak ditemukan.
                            </p>
                            <a href="<?= url('/?url=karyawan') ?>"
                                class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                                <i class="bi bi-arrow-left mr-2"></i>
                                Kembali ke Dashboard
                            </a>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </main>

        <!-- Footer -->
        <?php include __DIR__ . '/../partials/footer.php'; ?>
    </div>

    <!-- JavaScript -->
    <script>
        // Confirm delete function
        function confirmDelete(name) {
            return confirm(`Yakin ingin menghapus data "${name}"?`);
        }

        // Auto-hide alerts
        setTimeout(() => {
            const alerts = document.querySelectorAll('.joko-alert');
            alerts.forEach(alert => {
                alert.style.opacity = '0';
                alert.style.transition = 'opacity 0.5s';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);

        // Mobile menu toggle (already in navbar.php)
    </script>
</body>

</html>