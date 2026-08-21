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

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 1.5rem;
        }

        .register-card {
            background: #ffffff;
            width: 100%;
            max-width: 440px;
            border-radius: 1.5rem;
            border: 1px solid #f1f5f9;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            padding: 2.5rem 2rem;
        }

        .brand-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .brand-logo {
            height: 3.5rem;
            width: auto;
            margin-bottom: 1rem;
        }

        .brand-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: #064e3b;
            margin-bottom: 0.25rem;
        }

        .brand-subtitle {
            font-size: 0.875rem;
            color: #64748b;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 0.5rem;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #cbd5e1;
            border-radius: 0.75rem;
            font-size: 0.875rem;
            color: #0f172a;
            outline: none;
            transition: all 0.2s;
        }

        .form-input:focus {
            border-color: #064e3b;
            box-shadow: 0 0 0 3px rgba(6, 78, 59, 0.15);
        }

        .form-error {
            color: #dc2626;
            font-size: 0.75rem;
            margin-top: 0.375rem;
            font-weight: 500;
        }

        .btn-submit {
            width: 100%;
            background-color: #064e3b;
            color: #ffffff;
            border: none;
            padding: 0.875rem;
            border-radius: 0.75rem;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(6, 78, 59, 0.2);
            margin-top: 0.5rem;
        }

        .btn-submit:hover {
            background-color: #043e2f;
            box-shadow: 0 6px 16px rgba(6, 78, 59, 0.3);
        }

        .footer-link {
            text-align: center;
            margin-top: 1.75rem;
            font-size: 0.875rem;
            color: #64748b;
        }

        .footer-link a {
            color: #064e3b;
            font-weight: 700;
            text-decoration: none;
        }

        .footer-link a:hover {
            text-decoration: underline;
        }

        .toggle-password-btn {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            padding: 0.25rem;
            color: #64748b;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>

<body>
    <div class="register-card">
        <!-- Logo & Header -->
        <div class="brand-header">
            <img src="{{ asset('images/State_University_of_Surabaya_logo.png') }}" alt="UNESA Logo" class="brand-logo">
            <h1 class="brand-title">Daftar Akun</h1>
            <p class="brand-subtitle">Konseling Fakultas Teknik UNESA</p>
        </div>

        <!-- Form Registrasi -->
        <form action="{{ route('register.store') }}" method="POST">
            @csrf

            <!-- Nama Lengkap -->
            <div class="form-group">
                <label for="name" class="form-label">Nama Lengkap</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                    class="form-input" placeholder="Masukkan nama lengkap" required autofocus>
                @error('name')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email" class="form-label">Alamat Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}"
                    class="form-input" placeholder="nama@unesa.ac.id" required>
                @error('email')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <div style="position: relative;">
                    <input type="password" name="password" id="password"
                        class="form-input" style="padding-right: 2.75rem;" placeholder="Minimal 8 karakter" required>
                    <button type="button" class="toggle-password-btn" data-target="password" aria-label="Tampilkan atau sembunyikan password">
                        <svg class="eye-icon" style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
                @error('password')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Konfirmasi Password -->
            <div class="form-group">
                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                <div style="position: relative;">
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="form-input" style="padding-right: 2.75rem;" placeholder="Ulangi password" required>
                    <button type="button" class="toggle-password-btn" data-target="password_confirmation" aria-label="Tampilkan atau sembunyikan konfirmasi password">
                        <svg class="eye-icon" style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Tombol Register -->
            <button type="submit" class="btn-submit">
                Daftar Sekarang
            </button>
        </form>

        <!-- Footer Link ke Login -->
        <div class="footer-link">
            Sudah memiliki akun? <a href="{{ route('login') }}">Masuk di sini</a>
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