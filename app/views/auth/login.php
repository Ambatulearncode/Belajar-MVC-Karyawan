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
            <p class="mt-2 text-center text-sm text-gray-600">
                Hanya admin yang dapat mengakses dashboard
            </p>
        </div>

        <!-- Error Messages -->
        <?php if (!empty($errors)): ?>
            <div class="joko-alert joko-alert-danger">
                <div class="flex items-start">
                    <i class="bi bi-exclamation-triangle text-xl mr-3 mt-0.5"></i>
                    <div>
                        <h4 class="font-bold mb-2">Login Gagal</h4>
                        <ul class="list-disc pl-5 space-y-1">
                            <?php foreach ($errors as $error): ?>
                                <li><?= htmlspecialchars($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Login Form -->
        <form class="mt-8 space-y-6" method="POST" action="index.php?url=auth&action=authenticate">
            <div class="rounded-md shadow-sm -space-y-px">
                <!-- Username/Email -->
                <div>
                    <label for="username" class="sr-only">Username atau Email</label>
                    <input id="username" name="username" type="text"
                        value="<?= isset($old['username']) ? htmlspecialchars($old['username']) : '' ?>"
                        required
                        class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                        placeholder="Username atau Email">
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="sr-only">Password</label>
                    <input id="password" name="password" type="password"
                        required
                        class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                        placeholder="Password">
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