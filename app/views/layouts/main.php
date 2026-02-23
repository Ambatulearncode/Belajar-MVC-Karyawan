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

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        * {
            font-family: 'Jost', sans-serif !important;
        }

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

        /* Animation for notifications */
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }

            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }

        /* Zebra striping untuk tabel */
        .table-zebra tbody tr:nth-child(even) {
            background-color: #eff6ff;
            /* bg-blue-50 */
        }

        .table-zebra tbody tr:nth-child(even):hover {
            background-color: #dbeafe;
            /* bg-blue-100 saat hover */
        }
    </style>
</head>
<!-- Navbar -->
<?php include __DIR__ . '/../partials/navbar.php'; ?>

<body class="bg-gray-50 min-h-screen"
    <?php if (!empty($_SESSION['success'])): ?>
    data-success="<?= htmlspecialchars($_SESSION['success']) ?>"
    <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
    <?php if (!empty($_SESSION['error'])): ?>
    data-error="<?= htmlspecialchars($_SESSION['error']) ?>"
    <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    <?php if (!empty($_SESSION['info'])): ?>
    data-info="<?= htmlspecialchars($_SESSION['info']) ?>"
    <?php unset($_SESSION['info']); ?>
    <?php endif; ?>
    <?php if (!empty($_SESSION['warning'])): ?>
    data-warning="<?= htmlspecialchars($_SESSION['warning']) ?>"
    <?php unset($_SESSION['warning']); ?>
    <?php endif; ?>>
    <div
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

    <!-- JavaScript Files -->
    <script src="/belajar-mvc-karyawan/public/js/notifications.js"></script>
    <script src="/belajar-mvc-karyawan/public/js/form-handler.js"></script>

    <!-- Custom JavaScript -->
    <script>
        // Initialize when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-hide existing alerts
            setTimeout(() => {
                const alerts = document.querySelectorAll('.joko-alert');
                alerts.forEach(alert => {
                    // Add slide down animation
                    alert.style.transform = 'translateY(20px)';
                    alert.style.opacity = '0';
                    alert.style.transition = 'all 0.3s ease-out';

                    setTimeout(() => {
                        if (alert.parentNode) {
                            alert.parentNode.removeChild(alert);
                        }
                    }, 300);
                });
            }, 5000);

            // Confirm delete function (legacy support)
            window.confirmDelete = function(name, url) {
                if (window.FormHandler) {
                    window.FormHandler.showDeleteConfirmation(name, function() {
                        window.location.href = url;
                    });
                } else {
                    // Fallback to native confirm
                    if (confirm(`Yakin ingin menghapus data "${name}"?`)) {
                        window.location.href = url;
                    }
                }
                return false;
            };


            // Add loading state to all forms
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const submitButton = this.querySelector('button[type="submit"]');
                    if (submitButton && !submitButton.hasAttribute('data-no-loading')) {
                        const originalHTML = submitButton.innerHTML;
                        submitButton.innerHTML = `
                        <i class="bi bi-arrow-repeat animate-spin mr-2"></i>
                        Memproses...
                    `;
                        submitButton.disabled = true;

                        // Restore after 5 seconds (in case of error)
                        setTimeout(() => {
                            submitButton.innerHTML = originalHTML;
                            submitButton.disabled = false;
                        }, 5000);
                    }
                });
            });

            // Add data attributes for form validation
            const requiredFields = document.querySelectorAll('input[required], select[required], textarea[required]');
            requiredFields.forEach(field => {
                if (!field.hasAttribute('data-required-message')) {
                    field.setAttribute('data-required-message', 'Field ini wajib diisi');
                }
            });

            // Show session notifications
            if (window.Notifications) {
                window.Notifications.showSessionNotifications();
            }
        });

        // Handle AJAX form submissions
        document.addEventListener('ajaxFormSubmit', function(e) {
            const {
                form,
                response
            } = e.detail;

            if (response.success) {
                if (window.Notifications) {
                    window.Notifications.success(response.message || 'Berhasil!');
                }

                // Redirect if URL is provided
                if (response.redirect) {
                    setTimeout(() => {
                        window.location.href = response.redirect;
                    }, 1500);
                }

                // Reset form if needed
                if (response.resetForm) {
                    form.reset();
                }
            } else {
                if (window.Notifications) {
                    window.Notifications.error(response.message || 'Terjadi kesalahan!');
                }

                // Show field errors
                if (response.errors && window.FormHandler) {
                    Object.keys(response.errors).forEach(fieldName => {
                        const field = form.querySelector(`[name="${fieldName}"]`);
                        if (field) {
                            window.FormHandler.showFieldError(field, response.errors[fieldName][0]);
                        }
                    });
                }
            }
        });
    </script>