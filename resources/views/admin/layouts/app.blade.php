<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Admin Konseling Fakultas Teknik</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        /* ===== FULL OVERRIDE UNTUK ADMIN SIDEBAR (HIJAU FT UNESA) ===== */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            margin: 0;
        }

        /* 1. Sidebar Utuh */
        .admin-sidebar {
            background-color: #064e3b !important;
            background: #064e3b !important;
        }

        /* 2. Header / Logo Admin */
        .admin-logo {
            background-color: #043e2f !important;
            background: #043e2f !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
        }

        /* 3. Area Navigasi Menu */
        .admin-nav {
            background-color: #064e3b !important;
            background: #064e3b !important;
        }

        /* 4. Item Menu Biasa */
        .admin-nav-item {
            color: rgba(255, 255, 255, 0.85) !important;
            background-color: transparent !important;
            transition: all 0.2s ease;
            border-radius: 0.5rem;
        }

        .admin-nav-item:hover {
            background-color: rgba(255, 255, 255, 0.1) !important;
            color: #ffffff !important;
        }

        /* 5. Item Menu Aktif */
        .admin-nav-item.active {
            background-color: #043e2f !important;
            color: #ffffff !important;
            font-weight: 700 !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
        }

        /* 6. Section Profile Admin di Bawah */
        .admin-user-section {
            background-color: #043e2f !important;
            background: #043e2f !important;
            border-top: 1px solid rgba(255, 255, 255, 0.1) !important;
        }

        /* 7. Card Informasi Admin */
        .admin-user-card {
            background-color: rgba(255, 255, 255, 0.1) !important;
            background: rgba(255, 255, 255, 0.1) !important;
            border: 1px solid rgba(255, 255, 255, 0.15) !important;
            border-radius: 0.75rem;
        }

        .admin-user-avatar {
            background-color: #064e3b !important;
            color: #ffffff !important;
            border: 1px solid rgba(255, 255, 255, 0.3) !important;
        }

        .admin-user-name {
            color: #ffffff !important;
            font-weight: 700 !important;
        }

        .admin-user-email {
            color: rgba(255, 255, 255, 0.75) !important;
        }

        .rotate-180 {
            transform: rotate(180deg);
        }

        /* Notifications / Alert */
        .alert-success {
            background-color: #ecfdf5 !important;
            border: 1px solid #a7f3d0 !important;
            color: #064e3b !important;
            padding: 1rem 1.25rem;
            border-radius: 0.75rem;
            font-weight: 600;
        }

        .alert-danger {
            background-color: #fef2f2 !important;
            border: 1px solid #fecaca !important;
            color: #991b1b !important;
            padding: 1rem 1.25rem;
            border-radius: 0.75rem;
            font-weight: 600;
        }
    </style>

    @stack('styles')
</head>

<body style="background-color: #f8fafc;">
    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="admin-logo">
                <img src="{{ asset('images/State_University_of_Surabaya_logo.png') }}" alt="UNESA"
                    style="height: 2.25rem; filter: brightness(0) invert(1);">
                <div class="admin-brand">
                    <p class="admin-brand-title" style="color: #ffffff; font-weight: 800; margin: 0;">Admin Panel</p>
                    <p class="admin-brand-subtitle" style="color: rgba(255, 255, 255, 0.8); margin: 0;">Konseling Fakultas Teknik</p>
                </div>
            </div>

            <nav class="admin-nav"
                x-data="{ pertemuanOpen: {{ request()->routeIs('admin.schedules.*') || request()->routeIs('admin.bookings.*') || request()->routeIs('admin.counselors.*') ? 'true' : 'false' }} }">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}"
                    class="admin-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span>Dashboard</span>
                </a>

                <!-- Konseling Chat -->
                <a href="{{ route('admin.counseling.index') }}"
                    class="admin-nav-item {{ request()->routeIs('admin.counseling.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <span>Konseling Chat</span>
                </a>

                <!-- Konseling Pertemuan (with sub-menu) -->
                <div>
                    <button @click="pertemuanOpen = !pertemuanOpen" class="admin-nav-item"
                        style="width: 100%; justify-content: space-between; background: none; cursor: pointer; border: none; outline: none;">
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>Konseling Pertemuan</span>
                        </div>
                        <svg style="width: 1rem; height: 1rem; transition: transform 0.2s;"
                            :class="{ 'rotate-180': pertemuanOpen }" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="pertemuanOpen" x-collapse style="padding-left: 1.25rem; margin-top: 0.25rem;">
                        <a href="{{ route('admin.schedules.index') }}"
                            class="admin-nav-item {{ request()->routeIs('admin.schedules.*') ? 'active' : '' }}"
                            style="font-size: 0.875rem; padding: 0.625rem 1rem;">
                            <span
                                style="width: 0.375rem; height: 0.375rem; border-radius: 50%; background-color: currentColor;"></span>
                            Kelola Slot Jadwal
                        </a>
                        <a href="{{ route('admin.bookings.index') }}"
                            class="admin-nav-item {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}"
                            style="font-size: 0.875rem; padding: 0.625rem 1rem;">
                            <span
                                style="width: 0.375rem; height: 0.375rem; border-radius: 50%; background-color: currentColor;"></span>
                            Kelola Booking
                        </a>
                        {{-- SUB-MENU KELOLA KONSELOR --}}
                        <a href="{{ route('admin.counselors.index') }}"
                            class="admin-nav-item {{ request()->routeIs('admin.counselors.*') ? 'active' : '' }}"
                            style="font-size: 0.875rem; padding: 0.625rem 1rem;">
                            <span
                                style="width: 0.375rem; height: 0.375rem; border-radius: 50%; background-color: currentColor;"></span>
                            Kelola Konselor
                        </a>
                    </div>
                </div>
            </nav>

            <!-- User Info & Logout -->
            <div class="admin-user-section">
                <div class="admin-user-card">
                    <div class="admin-user-avatar">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="admin-user-info">
                        <p class="admin-user-name">{{ auth()->user()->name ?? 'Administrator' }}</p>
                        <p class="admin-user-email">{{ auth()->user()->email ?? '' }}</p>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            style="background: none; border: none; padding: 0.375rem; cursor: pointer; color: white; opacity: 0.85; transition: opacity 0.2s;"
                            onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.85'"
                            title="Logout">
                            <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="admin-content">
            @if(session('success'))
                <div class="alert alert-success" style="margin-bottom: 1.5rem;">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger" style="margin-bottom: 1.5rem;">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>

</html>