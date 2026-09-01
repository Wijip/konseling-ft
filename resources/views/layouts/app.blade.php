<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Layanan konseling fakultas teknik') - UNESA</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('styles')
</head>

<body class="bg-gray-50 font-['Inter'] text-gray-900 antialiased min-h-screen flex flex-col justify-between">
    <!-- Navbar -->
    <nav x-data="{ open: false }" class="bg-white border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Left: Logos & Title -->
                <div class="flex items-center gap-3 sm:gap-4">
                    <a href="{{ route('home') }}" class="flex-shrink-0">
                        <img src="{{ asset('images/State_University_of_Surabaya_logo.png') }}" alt="UNESA" class="h-10 sm:h-12 w-auto object-contain">
                    </a>
                    <div class="h-8 w-[1px] bg-gray-200 hidden sm:block"></div>
                    <div class="flex flex-col">
                        <span class="font-bold text-gray-900 text-xs sm:text-sm leading-tight">Konseling Fakultas Teknik</span>
                        <span class="text-[10px] sm:text-xs text-gray-500 font-medium tracking-wider">UNESA</span>
                    </div>
                </div>

                <!-- Center: Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-sm font-semibold text-gray-700 hover:text-[#064e3b] transition-colors">Beranda</a>
                    <a href="{{ route('tracking.index') }}" class="text-sm font-semibold text-gray-700 hover:text-[#064e3b] transition-colors">Cek Status</a>
                    @auth
                        @if(!in_array(Auth::user()->role, ['admin', 'konselor']))
                            <a href="{{ route('history') }}" class="text-sm font-semibold text-gray-700 hover:text-[#064e3b] transition-colors">Riwayat Konseling</a>
                        @endif
                    @endauth
                </div>

                <!-- Right: Actions (User / Admin / Guest) -->
                <div class="hidden md:flex items-center space-x-4">
                    @auth
                        <div class="flex items-center gap-3">
                            @if(in_array(Auth::user()->role, ['admin', 'konselor']))
                                <a href="{{ route('admin.dashboard') }}" class="px-5 py-2 border border-[#064e3b] text-[#064e3b] hover:bg-[#064e3b] hover:text-white rounded-full text-sm font-semibold transition-all">Dashboard Admin</a>
                            @else
                                <a href="{{ route('profile') }}" class="text-sm font-semibold text-gray-800 hover:text-[#064e3b] transition-colors flex items-center gap-1">
                                    👤 {{ Auth::user()->name }}
                                </a>
                            @endif

                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="px-4 py-1.5 border border-red-500 text-red-500 hover:bg-red-500 hover:text-white rounded-full text-sm font-semibold transition-all">
                                    Logout
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="px-6 py-2 border border-[#064e3b] text-[#064e3b] hover:bg-[#064e3b] hover:text-white rounded-full text-sm font-semibold transition-all">Login</a>
                    @endauth
                </div>

                <!-- Mobile Hamburger Button -->
                <div class="flex md:hidden">
                    <button @click="open = !open" type="button" class="text-gray-600 hover:text-gray-900 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="open" x-transition class="md:hidden bg-white border-b border-gray-200 px-4 pt-2 pb-4 space-y-3">
            <a href="{{ route('home') }}" class="block text-sm font-semibold text-gray-700 hover:text-[#064e3b] py-1">Beranda</a>
            <a href="{{ route('tracking.index') }}" class="block text-sm font-semibold text-gray-700 hover:text-[#064e3b] py-1">Cek Status</a>
            @auth
                @if(!in_array(Auth::user()->role, ['admin', 'konselor']))
                    <a href="{{ route('history') }}" class="block text-sm font-semibold text-gray-700 hover:text-[#064e3b] py-1">Riwayat Konseling</a>
                @endif
                <div class="pt-2 border-t border-gray-100 flex items-center justify-between">
                    @if(in_array(Auth::user()->role, ['admin', 'konselor']))
                        <a href="{{ route('admin.dashboard') }}" class="text-sm font-semibold text-[#064e3b]">Dashboard Admin</a>
                    @else
                        <a href="{{ route('profile') }}" class="text-sm font-semibold text-gray-800">👤 {{ Auth::user()->name }}</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-xs text-red-500 font-semibold border border-red-500 px-3 py-1 rounded-full">Logout</button>
                    </form>
                </div>
            @else
                <div class="pt-2 border-t border-gray-100">
                    <a href="{{ route('login') }}" class="inline-block px-5 py-1.5 border border-[#064e3b] text-[#064e3b] rounded-full text-xs font-semibold">Login</a>
                </div>
            @endauth
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow">
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-sm font-medium">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-sm font-medium">
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-100 py-6 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-xs sm:text-sm text-gray-500 font-medium">&copy; 2026 UNESA.</p>
        </div>
    </footer>

    @stack('scripts')
</body>

</html>