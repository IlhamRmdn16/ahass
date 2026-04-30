<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AHASS Surya Wijaya</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased h-screen flex items-center justify-center">
    <div class="max-w-md w-full mx-4">
        <!-- Logo & Header -->
        <div class="text-center mb-8 flex flex-col items-center justify-center">
            <img src="{{ asset('image/logo.webp') }}" alt="Logo Surya Wijaya" class="h-16 md:h-20 w-auto object-contain drop-shadow-md mb-2">
            <p class="text-gray-500 font-medium mt-2">Sistem Unit Entry AHASS</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-xl overflow-hidden border-t-4 border-red-600">
            <div class="p-8">
                <!-- Tampilkan Error jika login gagal -->
                @if ($errors->any())
                    <div class="mb-4 bg-red-50 p-3 rounded text-sm text-red-600 font-medium">
                        Kredensial yang Anda masukkan tidak cocok dengan data kami.
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <!-- Email -->
                    <div class="mb-5">
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email / Username</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500 transition-colors">
                    </div>

                    <!-- Password -->
                    <div class="mb-6">
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                        <input id="password" type="password" name="password" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500 transition-colors">
                    </div>

                    <!-- Remember Me & Forgot Password (Opsional) -->
                    <div class="flex items-center justify-between mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" name="remember" class="rounded border-gray-300 text-red-600 shadow-sm focus:ring-red-500">
                            <span class="ml-2 text-sm text-gray-600">Ingat Saya</span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-lg shadow-md transition duration-200 ease-in-out transform hover:-translate-y-0.5">
                        Masuk ke Sistem
                    </button>
                </form>
            </div>
            <div class="bg-gray-50 px-8 py-4 text-center text-xs text-gray-500 font-medium border-t border-gray-100">
                &copy; {{ date('Y') }} AHASS Surya Wijaya Garut. All rights reserved.
            </div>
        </div>
    </div>
</body>
</html>