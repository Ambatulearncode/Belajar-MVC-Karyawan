<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    </style>
</head>

<body class="bg-gray-50 min-h-screen">
    <div class="flex flex-col min-h-screen">
        <!-- Navbar -->
        <?php include __DIR__ . '/../partials/navbar.php'; ?>

        <!-- Main Content -->
        <main class="flex-grow py-8">
            <div class="container mx-auto px-4">
                <?php include __DIR__ . "/../{$view}.php"; ?>
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
    </script>
</body>

</html>