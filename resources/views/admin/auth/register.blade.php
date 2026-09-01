<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Admin - Konseling FT UNESA</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 font-sans min-h-screen flex items-center justify-center p-4 sm:p-6 antialiased text-slate-800">
    <div class="w-full max-w-md bg-white rounded-3xl border border-slate-100 shadow-xl p-6 sm:p-10">
        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <img src="{{ asset('images/State_University_of_Surabaya_logo.png') }}" alt="UNESA Logo" class="h-14 w-auto mx-auto mb-4">
            <h1 class="text-2xl font-extrabold text-[#064e3b] mb-1">Daftar Akun</h1>
            <p class="text-sm text-slate-500">Konseling Fakultas Teknik UNESA</p>
        </div>

        <!-- Form Registrasi -->
        <form action="{{ route('register.store') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Nama Lengkap -->
            <div>
                <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                    class="w-full px-4 py-3 border rounded-xl text-sm text-slate-900 focus:outline-none focus:border-[#064e3b] focus:ring-2 focus:ring-[#064e3b]/20 transition-all placeholder-slate-400 @error('name') border-red-500 @else border-slate-300 @enderror" 
                    placeholder="Masukkan nama lengkap" required autofocus>
                @error('name')
                    <p class="text-red-600 text-xs mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Alamat Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}"
                    class="w-full px-4 py-3 border rounded-xl text-sm text-slate-900 focus:outline-none focus:border-[#064e3b] focus:ring-2 focus:ring-[#064e3b]/20 transition-all placeholder-slate-400 @error('email') border-red-500 @else border-slate-300 @enderror" 
                    placeholder="nama@unesa.ac.id" required>
                @error('email')
                    <p class="text-red-600 text-xs mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
                <div class="relative">
                    <input type="password" name="password" id="password"
                        class="w-full px-4 py-3 pr-11 border rounded-xl text-sm text-slate-900 focus:outline-none focus:border-[#064e3b] focus:ring-2 focus:ring-[#064e3b]/20 transition-all placeholder-slate-400 @error('password') border-red-500 @else border-slate-300 @enderror" 
                        placeholder="Minimal 8 karakter" required>
                    <button type="button" class="toggle-password-btn absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 p-1 cursor-pointer flex items-center justify-center transition-colors" 
                        data-target="password" aria-label="Tampilkan atau sembunyikan password">
                        <svg class="eye-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
                @error('password')
                    <p class="text-red-600 text-xs mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Konfirmasi Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-2">Konfirmasi Password</label>
                <div class="relative">
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="w-full px-4 py-3 pr-11 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-[#064e3b] focus:ring-2 focus:ring-[#064e3b]/20 transition-all placeholder-slate-400" 
                        placeholder="Ulangi password" required>
                    <button type="button" class="toggle-password-btn absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 p-1 cursor-pointer flex items-center justify-center transition-colors" 
                        data-target="password_confirmation" aria-label="Tampilkan atau sembunyikan konfirmasi password">
                        <svg class="eye-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Tombol Register -->
            <button type="submit" class="w-full bg-[#064e3b] hover:bg-[#043e2f] text-white font-bold py-3.5 px-6 rounded-xl shadow-md hover:shadow-lg transition-all text-sm mt-2 cursor-pointer">
                Daftar Sekarang
            </button>
        </form>

        <!-- Footer Link ke Login -->
        <div class="text-center mt-7 text-sm text-slate-500">
            Sudah memiliki akun? <a href="{{ route('login') }}" class="text-[#064e3b] font-bold hover:underline transition-all">Masuk di sini</a>
        </div>
    </div>

    <!-- Script Toggle Show/Hide Password -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleButtons = document.querySelectorAll('.toggle-password-btn');

            toggleButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const targetId = this.getAttribute('data-target');
                    const input = document.getElementById(targetId);
                    const eyeIcon = this.querySelector('.eye-icon');

                    if (input && eyeIcon) {
                        const isPassword = input.type === 'password';
                        input.type = isPassword ? 'text' : 'password';

                        if (isPassword) {
                            // Eye Slash Icon
                            eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a10.025 10.025 0 011.832-.443c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21M3 3l18 18" />`;
                        } else {
                            // Eye Open Icon
                            eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>