<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Konseling Fakultas Teknik UNESA</title>
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
                <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mb-2">Verifikasi & Reset Password</h1>
                <p class="text-gray-500 text-sm">Masukkan kode OTP 6 digit dari WhatsApp dan tentukan password baru akun Anda</p>
            </div>

            <!-- Session Status Alert -->
            @if (session('status'))
                <div class="mb-5 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-medium flex items-start gap-2.5">
                    <svg class="w-5 h-5 text-emerald-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <!-- Session Error Alert -->
            @if (session('error'))
                <div class="mb-5 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm font-medium flex items-start gap-2.5">
                    <svg class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- Form Section -->
            <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Nomor WhatsApp -->
                <div>
                    <label for="phone_number" class="block text-sm font-semibold text-gray-700 mb-1.5">Nomor WhatsApp</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-5 h-5 text-[#25D366]" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                            </svg>
                        </div>
                        <input type="tel" name="phone_number" id="phone_number" value="{{ old('phone_number', $phone ?? '') }}"
                            class="w-full pl-11 pr-4 py-3 border rounded-xl text-sm transition-all focus:outline-none focus:border-[#064e3b] focus:ring-2 focus:ring-[#064e3b]/20 @error('phone_number') border-red-500 @else border-gray-300 @enderror"
                            placeholder="Contoh: 081234567890" required>
                    </div>
                    @error('phone_number')
                        <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kode OTP (6 Digit) -->
                <div>
                    <label for="otp" class="block text-sm font-semibold text-gray-700 mb-1.5">Kode OTP (6 Digit)</label>
                    <div class="relative">
                        <input type="text" name="otp" id="otp" value="{{ old('otp') }}"
                            maxlength="6" inputmode="numeric" pattern="[0-9]{6}" autocomplete="one-time-code"
                            class="w-full px-4 py-3 border rounded-xl text-center text-lg font-mono tracking-widest font-bold transition-all focus:outline-none focus:border-[#064e3b] focus:ring-2 focus:ring-[#064e3b]/20 @error('otp') border-red-500 @else border-gray-300 @enderror"
                            placeholder="123456" required autofocus>
                    </div>
                    @error('otp')
                        <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Baru Input -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5">Password Baru</label>
                    <div class="relative">
                        <input type="password" name="password" id="password"
                            class="w-full px-4 py-3 pr-11 border rounded-xl text-sm transition-all focus:outline-none focus:border-[#064e3b] focus:ring-2 focus:ring-[#064e3b]/20 @error('password') border-red-500 @else border-gray-300 @enderror"
                            placeholder="Minimal 8 karakter" required>
                        <button type="button" class="toggle-password-btn absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 p-1 cursor-pointer flex items-center justify-center transition-colors"
                            data-target="password" aria-label="Tampilkan atau sembunyikan password">
                            <svg class="eye-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Konfirmasi Password Baru Input -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1.5">Konfirmasi Password Baru</label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="w-full px-4 py-3 pr-11 border rounded-xl text-sm border-gray-300 transition-all focus:outline-none focus:border-[#064e3b] focus:ring-2 focus:ring-[#064e3b]/20"
                            placeholder="Ulangi password baru" required>
                        <button type="button" class="toggle-password-btn absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 p-1 cursor-pointer flex items-center justify-center transition-colors"
                            data-target="password_confirmation" aria-label="Tampilkan atau sembunyikan konfirmasi password">
                            <svg class="eye-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" class="w-full bg-[#064e3b] hover:bg-[#043e2f] text-white font-bold py-3.5 px-4 rounded-xl shadow-md hover:shadow-lg transition-all text-base cursor-pointer">
                        Perbarui Password
                    </button>
                </div>
            </form>

            <!-- Kirim Ulang OTP & Kembali ke Login -->
            <div class="mt-6 pt-5 border-t border-gray-100 text-center space-y-2">
                <p class="text-xs text-gray-500">
                    Tidak menerima kode OTP? 
                    <a href="{{ route('password.request') }}" class="font-bold text-[#064e3b] hover:underline">
                        Kirim Ulang OTP
                    </a>
                </p>
                <div>
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-600 hover:text-[#064e3b] hover:underline inline-block mt-1">
                        ← Kembali ke Halaman Login
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer Copyright -->
        <div class="mt-8 text-center text-xs text-gray-400 font-medium">
            &copy; {{ date('Y') }} Fakultas Teknik UNESA. All rights reserved.
        </div>
    </div>

    <!-- Script Toggle Password Visibility -->
    <script>
        document.querySelectorAll('.toggle-password-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const targetId = this.getAttribute('data-target');
                const input = document.getElementById(targetId);
                const icon = this.querySelector('.eye-icon');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                    `;
                } else {
                    input.type = 'password';
                    icon.innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    `;
                }
            });
        });
    </script>
</body>

</html>