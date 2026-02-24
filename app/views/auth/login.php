<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <!-- Header -->
        <div>
            <div class="mx-auto h-12 w-12 flex items-center justify-center rounded-full bg-blue-100">
                <i class="bi bi-shield-lock text-blue-600 text-2xl"></i>
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Login ke Sistem Karyawan
            </h2>
            <p class="mt-2 text-center text-m text-gray-600">
                Hanya admin yang dapat mengakses dashboard
            </p>
        </div>


        <!-- Login Form -->
        <form class="mt-8 space-y-6" method="POST" action="index.php?url=auth&action=authenticate">
            <div class="rounded-md shadow-sm">
                <div class="mb-4">
                    <input type="text"
                        id="username"
                        name="username"
                        value="<?= htmlspecialchars($_SESSION['old']['identifier'] ?? '') ?>"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition"
                        placeholder="Masukkan username atau email"
                        required>
                </div>

                <!-- Password Field -->
                <div>
                    <div class="relative">
                        <input type="password"
                            id="password"
                            name="password"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition pr-10"
                            placeholder="Masukkan password"
                            required>
                        <button type="button"
                            onclick="togglePassword()"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                            <i class="bi bi-eye" id="password-toggle-icon"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Remember Me (Optional) -->
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember_me" name="remember_me" type="checkbox"
                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="remember_me" class="ml-2 block text-sm text-gray-900">
                        Ingat saya
                    </label>
                </div>

                <div class="text-sm">
                    <a href="#" class="font-medium text-blue-600 hover:text-blue-500">
                        Lupa password?
                    </a>
                </div>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit"
                    class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <i class="bi bi-box-arrow-in-right text-blue-500 group-hover:text-blue-400"></i>
                    </span>
                    Masuk ke Sistem
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Password Toggle Script -->
<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const icon = document.getElementById('password-toggle-icon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    }
</script>