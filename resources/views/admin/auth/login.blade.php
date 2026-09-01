<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Konseling Fakultas Teknik UNESA</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-50 flex items-center justify-center font-['Inter'] antialiased p-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8 sm:p-10">
            
            <!-- Header Section -->
            <div class="text-center mb-8">
                <div class="mb-4">
                    <img src="{{ asset('images/State_University_of_Surabaya_logo.png') }}" alt="UNESA" class="h-16 mx-auto object-contain">
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mb-1">Login</h1>
                <p class="text-gray-500 text-sm">Layanan konseling fakultas teknik</p>
            </div>

            <!-- Form Section -->
            <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                        class="w-full px-4 py-3 border rounded-xl text-sm transition-all focus:outline-none focus:border-[#064e3b] focus:ring-2 focus:ring-[#064e3b]/20 @error('email') border-red-500 @else border-gray-300 @enderror"
                        placeholder="admin@unesa.ac.id" required autofocus>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Input dengan Toggle Eye Icon -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                    <div class="relative">
                        <input type="password" name="password" id="password"
                            class="w-full pl-4 pr-11 py-3 border rounded-xl text-sm transition-all focus:outline-none focus:border-[#064e3b] focus:ring-2 focus:ring-[#064e3b]/20 @error('password') border-red-500 @else border-gray-300 @enderror"
                            placeholder="••••••••" required>
                        <button type="button" id="togglePassword"
                            class="absolute right-3 top-1/2 -translate-y-1/2 p-1 text-gray-500 hover:text-gray-700 transition-colors focus:outline-none"
                            aria-label="Tampilkan atau sembunyikan password">
                            <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Checkbox Ingat Saya -->
                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember"
                        class="w-4 h-4 text-[#064e3b] border-gray-300 rounded focus:ring-[#064e3b] accent-[#064e3b] cursor-pointer">
                    <label for="remember" class="ml-2 text-sm text-gray-600 cursor-pointer select-none">Ingat saya</label>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" class="w-full bg-[#064e3b] hover:bg-[#043e2f] text-white font-bold py-3.5 px-4 rounded-xl shadow-md hover:shadow-lg transition-all text-base cursor-pointer">
                        Masuk
                    </button>
                </div>
            </form>

            <!-- Register Link -->
            <div class="mt-5 text-center text-sm text-gray-600">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="text-[#064e3b] font-bold hover:underline">
                    Daftar di sini
                </a>
            </div>

            <!-- Back Link -->
            <div class="mt-6 pt-5 border-t border-gray-100 text-center">
                <a href="{{ route('home') }}" class="text-sm font-medium text-gray-500 hover:text-[#064e3b] transition-colors">
                    ← Kembali ke Beranda
                </a>
            </div>
        </div>

        <!-- Footer Copyright -->
        <div class="mt-8 text-center text-xs text-gray-400 font-medium">
            &copy; {{ date('Y') }} Fakultas Teknik UNESA. All rights reserved.
        </div>
    </div>

    <!-- Script Toggle Password -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const passwordInput = document.getElementById('password');
            const toggleBtn = document.getElementById('togglePassword');
            const eyeIcon = document.getElementById('eyeIcon');

            if (passwordInput && toggleBtn && eyeIcon) {
                toggleBtn.addEventListener('click', function () {
                    const isPassword = passwordInput.type === 'password';
                    passwordInput.type = isPassword ? 'text' : 'password';

                    if (isPassword) {
                        eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a10.025 10.025 0 011.832-.443c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21M3 3l18 18" />`;
                    } else {
                        eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
                    }
                });
            }
        });
    </script>
</body>

</html>