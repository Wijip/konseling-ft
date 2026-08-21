<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Konseling Fakultas Teknik UNESA</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <style>
        .form-input:focus {
            border-color: #064e3b !important;
            outline: none;
            box-shadow: 0 0 0 3px rgba(6, 78, 59, 0.15) !important;
        }
        .btn-green {
            background-color: #064e3b;
            color: #ffffff;
            border: none;
            border-radius: 0.75rem;
            font-weight: 700;
            transition: all 0.2s ease;
            cursor: pointer;
        }
        .btn-green:hover {
            background-color: #043e2f;
            box-shadow: 0 4px 12px rgba(6, 78, 59, 0.25);
        }
    </style>
</head>

<body style="min-height: 100vh; background-color: #f9fafb; display: flex; align-items: center; justify-content: center; font-family: 'Inter', sans-serif;">
    <div style="width: 100%; max-width: 28rem; padding: 0 1rem;">
        <div class="card" style="border-radius: 1.5rem; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08); padding: 2.5rem 2rem; background: #ffffff;">
            
            <!-- Header Section -->
            <div style="text-align: center; margin-bottom: 2rem;">
                <div style="margin-bottom: 1rem;">
                    <img src="{{ asset('images/State_University_of_Surabaya_logo.png') }}" alt="UNESA"
                        style="height: 4.5rem; margin: 0 auto; display: block; object-fit: contain;">
                </div>

                <h1 style="font-size: 1.75rem; font-weight: 800; color: #111827; margin-bottom: 0.25rem;">Login</h1>
                <p style="color: #6b7280; font-size: 0.875rem; margin: 0;">Layanan konseling fakultas teknik</p>
            </div>

            <!-- Form Section -->
            <form action="{{ route('login.post') }}" method="POST">
                @csrf

                <!-- Email Input -->
                <div class="form-group" style="margin-bottom: 1.25rem;">
                    <label for="email" class="form-label" style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                        class="form-input @error('email') border-red-500 @enderror" placeholder="admin@unesa.ac.id"
                        style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #d1d5db; border-radius: 0.75rem; font-size: 0.875rem;"
                        required autofocus>
                    @error('email')
                        <p class="form-error" style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Input dengan Toggle Eye Icon -->
                <div class="form-group" style="margin-bottom: 1.25rem;">
                    <label for="password" class="form-label" style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Password</label>
                    <div style="position: relative;">
                        <input type="password" name="password" id="password"
                            class="form-input @error('password') border-red-500 @enderror" placeholder="••••••••"
                            style="width: 100%; padding: 0.75rem 2.75rem 0.75rem 1rem; border: 1px solid #d1d5db; border-radius: 0.75rem; font-size: 0.875rem; box-sizing: border-box;"
                            required>
                        <button type="button" id="togglePassword"
                            style="position: absolute; right: 0.75rem; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; padding: 0.25rem; color: #6b7280; display: flex; align-items: center; justify-content: center;"
                            aria-label="Tampilkan atau sembunyikan password">
                            <svg id="eyeIcon" style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <!-- Eye Open Icon -->
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="form-error" style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Checkbox Ingat Saya -->
                <div style="display: flex; align-items: center; margin-bottom: 1.75rem;">
                    <input type="checkbox" name="remember" id="remember"
                        style="width: 1rem; height: 1rem; accent-color: #064e3b; border-color: #d1d5db; border-radius: 0.25rem; cursor: pointer;">
                    <label for="remember" style="margin-left: 0.5rem; font-size: 0.875rem; color: #6b7280; cursor: pointer;">Ingat saya</label>
                </div>

                <!-- Submit Button -->
                <div style="display: flex; justify-content: center;">
                    <button type="submit" class="btn-green"
                        style="font-size: 1rem; padding: 0.875rem; font-weight: 700; width: 100%;">
                        Masuk
                    </button>
                </div>
            </form>

            <!-- Register Link -->
            <div style="margin-top: 1.25rem; text-align: center; font-size: 0.875rem; color: #6b7280;">
                Belum punya akun? 
                <a href="{{ route('register') }}"
                    style="color: #064e3b; font-weight: 700; text-decoration: none;"
                    onmouseover="this.style.textDecoration='underline'"
                    onmouseout="this.style.textDecoration='none'">
                    Daftar di sini
                </a>
            </div>

            <!-- Back Link -->
            <div style="margin-top: 1.5rem; text-align: center; padding-top: 1.25rem; border-top: 1px solid #f3f4f6;">
                <a href="{{ route('home') }}"
                    style="color: #6b7280; text-decoration: none; font-size: 0.875rem; font-weight: 500; transition: color 0.2s;"
                    onmouseover="this.style.color='#064e3b'" onmouseout="this.style.color='#6b7280'">
                    ← Kembali ke Beranda
                </a>
            </div>
        </div>

        <!-- Footer Copyright -->
        <div style="margin-top: 2rem; text-align: center; font-size: 0.75rem; color: #9ca3af;">
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
                        // Eye Slash Icon (Sembunyi)
                        eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a10.025 10.025 0 011.832-.443c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21M3 3l18 18" />`;
                    } else {
                        // Eye Open Icon (Tampil)
                        eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
                    }
                });
            }
        });
    </script>
</body>

</html>