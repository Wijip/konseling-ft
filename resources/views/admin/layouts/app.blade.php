<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Admin Konseling Fakultas Teknik</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>[x-cloak] { display: none !important; }</style>
    @stack('styles')
</head>

<body class="bg-slate-50 font-sans antialiased min-h-screen text-slate-800" x-data="{ sidebarOpen: false }">
    <div class="flex flex-col md:flex-row min-h-screen">
        
        <!-- Mobile Top Navbar -->
        <header class="bg-[#064e3b] text-white p-4 flex items-center justify-between md:hidden shadow-md z-30">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/State_University_of_Surabaya_logo.png') }}" alt="UNESA" class="h-8 w-auto brightness-0 invert">
                <div>
                    <p class="font-extrabold text-xs leading-tight">Admin Panel</p>
                    <p class="text-white/80 text-[10px] leading-tight">Konseling FT UNESA</p>
                </div>
            </div>
            <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-lg bg-[#043e2f] text-white hover:bg-emerald-800 transition-colors focus:outline-none cursor-pointer">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path x-show="!sidebarOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path x-show="sidebarOpen" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </header>

        <!-- Mobile Backdrop -->
        <div x-show="sidebarOpen" 
            x-cloak
            @click="sidebarOpen = false" 
            x-transition:enter="transition-opacity ease-linear duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-slate-900/50 z-40 md:hidden">
        </div>

        <!-- Sidebar (Drawer di Mobile, Fixed di Desktop) -->
        <aside 
            class="fixed inset-y-0 left-0 z-50 w-64 bg-[#064e3b] flex flex-col justify-between shrink-0 shadow-xl transform -translate-x-full transition-transform duration-300 ease-in-out md:static md:translate-x-0"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            
            <div>
                <!-- Logo & Brand Header -->
                <div class="bg-[#043e2f] p-5 border-b border-white/10 flex items-center justify-between md:justify-start gap-3">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/State_University_of_Surabaya_logo.png') }}" alt="UNESA"
                            class="h-9 w-auto brightness-0 invert">
                        <div>
                            <p class="text-white font-extrabold text-sm leading-tight">Admin Panel</p>
                            <p class="text-white/80 text-xs leading-tight">Konseling Fakultas Teknik</p>
                        </div>
                    </div>
                    <button @click="sidebarOpen = false" class="md:hidden text-white/80 hover:text-white p-1 cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Navigation Menu -->
                <nav class="p-4 space-y-1.5"
                    x-data="{ pertemuanOpen: {{ request()->routeIs('admin.schedules.*') || request()->routeIs('admin.bookings.*') || request()->routeIs('admin.counselors.*') ? 'true' : 'false' }} }">
                    
                    <!-- Dashboard -->
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm transition-all font-medium
                        {{ request()->routeIs('admin.dashboard') ? 'bg-[#043e2f] text-white font-bold shadow-md' : 'text-white/85 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span>Dashboard</span>
                    </a>

                    <!-- Konseling Chat -->
                    <a href="{{ route('admin.counseling.index') }}"
                        class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm transition-all font-medium
                        {{ request()->routeIs('admin.counseling.*') ? 'bg-[#043e2f] text-white font-bold shadow-md' : 'text-white/85 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <span>Konseling Chat</span>
                    </a>

                    <!-- Konseling Pertemuan -->
                    <div>
                        <button @click="pertemuanOpen = !pertemuanOpen" 
                            class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm text-white/85 hover:bg-white/10 hover:text-white transition-all font-medium cursor-pointer">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>Konseling Pertemuan</span>
                            </div>
                            <svg class="w-4 h-4 transition-transform duration-200"
                                :class="{ 'rotate-180': pertemuanOpen }" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="pertemuanOpen" x-cloak x-collapse class="pl-5 mt-1 space-y-1">
                            <a href="{{ route('admin.schedules.index') }}"
                                class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-all
                                {{ request()->routeIs('admin.schedules.*') ? 'bg-[#043e2f] text-white font-bold' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-current shrink-0"></span>
                                Kelola Slot Jadwal
                            </a>
                            <a href="{{ route('admin.bookings.index') }}"
                                class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-all
                                {{ request()->routeIs('admin.bookings.*') ? 'bg-[#043e2f] text-white font-bold' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-current shrink-0"></span>
                                Kelola Booking
                            </a>
                            <a href="{{ route('admin.counselors.index') }}"
                                class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-all
                                {{ request()->routeIs('admin.counselors.*') ? 'bg-[#043e2f] text-white font-bold' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-current shrink-0"></span>
                                Kelola Konselor
                            </a>
                        </div>
                    </div>
                </nav>
            </div>

            <!-- Sidebar Footer -->
            <div class="p-4 border-t border-white/10 text-center">
                <p class="text-[11px] text-white/60 font-semibold tracking-wide">FT UNESA</p>
                <p class="text-[10px] text-white/40 mt-0.5">&copy; {{ date('Y') }} Layanan Konseling</p>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 w-full min-w-0 p-4 sm:p-6 lg:p-10 overflow-y-auto">
            
            <!-- Topbar Header (Title & Subtitle + Top-Right Profile & Logout Widget) -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 sm:mb-8">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-[#064e3b] tracking-tight">
                        @yield('header_title', View::getSection('title', 'Dashboard'))
                    </h1>
                    <p class="text-slate-500 text-sm sm:text-base mt-1">
                        @yield('header_subtitle', 'Selamat datang, ' . (auth()->user()->name ?? 'Admin FT UNESA'))
                    </p>
                </div>

                <!-- User Profile & Logout Widget (Pojok Kanan Atas - Sesuai Lingkaran Biru) -->
                <div class="flex items-center gap-3 self-start sm:self-auto shrink-0">
                    <div class="bg-white pl-2.5 pr-3 py-1.5 sm:pl-3 sm:pr-3.5 sm:py-2 rounded-2xl border border-slate-200/90 shadow-sm hover:shadow-md hover:border-emerald-300 transition-all flex items-center gap-3">
                        <!-- Profile Button / Link -->
                        <a href="{{ route('admin.profile.edit') }}" 
                           class="flex items-center gap-2.5 sm:gap-3 min-w-0 group"
                           title="Klik untuk kelola Profil & Ganti Password">
                            <!-- Avatar Circle -->
                            <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-[#064e3b] text-white font-extrabold text-xs sm:text-sm flex items-center justify-center border-2 border-emerald-100 shadow-xs overflow-hidden shrink-0 group-hover:scale-105 transition-transform">
                                @if(auth()->user()->avatar)
                                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Avatar" class="w-full h-full object-cover">
                                @else
                                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                                @endif
                            </div>
                            
                            <!-- Identity Info -->
                            <div class="min-w-0 text-left">
                                <div class="flex items-center gap-1.5">
                                    <span class="text-xs sm:text-sm font-bold text-slate-800 group-hover:text-[#064e3b] transition-colors truncate max-w-[120px] sm:max-w-[160px] leading-tight">
                                        {{ auth()->user()->name ?? 'Administrator' }}
                                    </span>
                                    <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-[#064e3b] shrink-0 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </div>
                                <div class="flex items-center gap-1.5 mt-0.5">
                                    <span class="bg-emerald-50 text-[#064e3b] text-[10px] font-extrabold px-1.5 py-0.2 rounded border border-emerald-200/70 shrink-0">Admin</span>
                                    <span class="text-slate-400 text-[11px] truncate max-w-[110px] sm:max-w-[150px] font-medium leading-tight">
                                        {{ auth()->user()->email ?? '' }}
                                    </span>
                                </div>
                            </div>
                        </a>

                        <!-- Divider Separator -->
                        <div class="h-7 w-px bg-slate-200 shrink-0"></div>

                        <!-- Logout Form -->
                        <form action="{{ route('logout') }}" method="POST" class="shrink-0 m-0">
                            @csrf
                            <button type="submit"
                                class="flex items-center gap-1.5 px-2.5 py-1.5 sm:px-3 sm:py-2 text-slate-500 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all text-xs font-semibold cursor-pointer group"
                                title="Logout dari Sistem">
                                <svg class="w-4 h-4 text-slate-400 group-hover:text-red-600 transition-colors shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                <span class="hidden md:inline group-hover:text-red-600 transition-colors">Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-[#064e3b] p-4 rounded-xl font-semibold mb-6 text-sm flex items-center justify-between">
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-800 p-4 rounded-xl font-semibold mb-6 text-sm flex items-center justify-between">
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Script Global Toggle Password -->
    <script>
        document.addEventListener('click', function (e) {
            const button = e.target.closest('.toggle-password-btn');
            if (!button) return;

            const targetId = button.getAttribute('data-target');
            const input = document.getElementById(targetId);
            const eyeIcon = button.querySelector('.eye-icon');

            if (input && eyeIcon) {
                const isPassword = input.type === 'password';
                input.type = isPassword ? 'text' : 'password';

                if (isPassword) {
                    eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a10.025 10.025 0 011.832-.443c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21M3 3l18 18" />`;
                } else {
                    eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
                }
            }
        });
    </script>

    @stack('scripts')
</body>

</html>