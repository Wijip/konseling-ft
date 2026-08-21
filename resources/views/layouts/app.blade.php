<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Layanan konseling fakultas teknik') - UNESA</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mobile.css') }}">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('styles')
</head>

<body>
    <!-- Navbar -->
    <nav>
        <div class="nav-container">
            <div class="nav-content">
                <!-- Left: Logos -->
                <div class="nav-logos">
                    <div>
                        <img src="{{ asset('images/State_University_of_Surabaya_logo.png') }}" alt="UNESA"
                            style="height: 3.2rem; width:auto; object-fit: contain;">
                    </div>
                    <div class="nav-divider"></div>
                    <div class="nav-title">
                        <div class="nav-text">
                            <strong>Konseling Fakultas Teknik</strong>
                            <small>UNESA</small>
                        </div>
                    </div>
                </div>

                <!-- Center: Desktop Navigation -->
                <div class="nav-menu">
                    <a href="{{ route('home') }}">Beranda</a>
                    <a href="{{ route('tracking.index') }}">Cek Status</a>
                </div>

                <!-- Right: Actions (User / Admin / Guest) -->
                <div class="nav-actions">
                    @auth
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            @if(in_array(Auth::user()->role, ['admin', 'konselor']))
                                <!-- Tampilan jika Login sebagai Admin/Konselor -->
                                <a href="{{ route('admin.dashboard') }}" class="btn-login">Dashboard Admin</a>
                            @else
                                <!-- Tampilan jika Login sebagai User biasa -->
                                <span style="font-weight: 600; color: #1e293b; font-size: 0.875rem;">
                                    {{ Auth::user()->name }}
                                </span>
                            @endif

                            <!-- Tombol Logout -->
                            <form action="{{ route('logout') }}" method="POST" style="margin: 0; display: inline;">
                                @csrf
                                <button type="submit" 
                                    style="padding: 0.4rem 1rem; border: 1px solid #ef4444; background-color: transparent; color: #ef4444; border-radius: 9999px; font-weight: 600; font-size: 0.875rem; cursor: pointer; transition: all 0.2s;"
                                    onmouseover="this.style.backgroundColor='#ef4444'; this.style.color='#ffffff';"
                                    onmouseout="this.style.backgroundColor='transparent'; this.style.color='#ef4444';">
                                    Logout
                                </button>
                            </form>
                        </div>
                    @else
                        <!-- Tampilan jika Belum Login -->
                        <a href="{{ route('login') }}" class="btn-login">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @if(session('success'))
            <div style="max-width: 1280px; margin: 0 auto; padding: 1rem;">
                <div
                    style="background-color: #d1fae5; border: 1px solid #10b981; color: #047857; padding: 1rem; border-radius: 0.5rem;">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div style="max-width: 1280px; margin: 0 auto; padding: 1rem;">
                <div
                    style="background-color: #fee2e2; border: 1px solid #ef4444; color: #b91c1c; padding: 1rem; border-radius: 0.5rem;">
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <p>&copy; 2026 UNESA.</p>
        </div>
    </footer>

    @stack('scripts')
</body>

</html>