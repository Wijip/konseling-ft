<nav class="navbar" style="background: white; border-bottom: 1px solid #E5E7EB; height: 80px; display: flex; align-items: center;">
    <div class="container" style="max-width: 1280px; margin: 0 auto; padding: 0 2rem; width: 100%; display: flex; align-items: center; justify-content: space-between;">
        
        <!-- Left: Logo & Title -->
        <a href="{{ route('home') }}" style="text-decoration: none; display: flex; align-items: center; gap: 1rem;">
            <img src="{{ asset('images/State_University_of_Surabaya_logo.png') }}" alt="UNESA" style="height: 48px; width: auto; object-fit: contain;">
            <div>
                <h1 style="font-size: 1rem; margin: 0; color: #064e3b; font-weight: 800; line-height: 1.2; letter-spacing: 0.025em;">FAKULTAS TEKNIK</h1>
                <p style="font-size: 0.85rem; margin: 0; color: #4b5563; font-weight: 500;">Universitas Negeri Surabaya</p>
            </div>
        </a>

        <!-- Center: Navigation Links -->
        <div style="display: flex; gap: 2.5rem; align-items: center;">
            <a href="{{ route('home') }}" style="color: {{ request()->routeIs('home') ? '#064e3b' : '#374151' }}; font-weight: 700; font-size: 0.95rem; text-decoration: none; position: relative; padding-bottom: 4px; {{ request()->routeIs('home') ? 'border-bottom: 3px solid #064e3b;' : '' }}">
                Beranda
            </a>
            <a href="{{ route('tracking.index') }}" style="color: {{ request()->routeIs('tracking.*') ? '#064e3b' : '#374151' }}; font-weight: 700; font-size: 0.95rem; text-decoration: none; position: relative; padding-bottom: 4px; {{ request()->routeIs('tracking.*') ? 'border-bottom: 3px solid #064e3b;' : '' }}">
                Cek Status
            </a>
            <a href="{{ route('home') }}#layanan" style="color: #374151; font-weight: 600; font-size: 0.95rem; text-decoration: none;">
                Tentang Layanan
            </a>
            <a href="{{ route('home') }}#faq" style="color: #374151; font-weight: 600; font-size: 0.95rem; text-decoration: none;">
                FAQ
            </a>
        </div>

        <!-- Right: Admin Login Button -->
        <div>
            <a href="{{ route('login') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; border: 1.5px solid #064e3b; color: #064e3b; border-radius: 9999px; padding: 0.5rem 1.25rem; font-size: 0.875rem; font-weight: 600; text-decoration: none; background: transparent;">
                <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                Admin Login
            </a>
        </div>
    </div>
</nav>