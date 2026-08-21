<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Layanan Konseling Fakultas Teknik UNESA')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/variables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mobile.css') }}">

    <!-- Scripts -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body style="min-height: 100vh; display: flex; flex-direction: column; margin: 0; font-family: 'Inter', sans-serif;">
    @include('components.navbar')

    <main style="flex: 1;">
        @yield('content')
    </main>

    <footer style="background-color: #064e3b; color: #ffffff; padding: 1.25rem 0; text-align: center; font-size: 0.875rem; margin-top: auto;">
        <div class="container" style="max-width: 1280px; margin: 0 auto; padding: 0 2rem;">
            <p style="margin: 0; opacity: 0.9; font-weight: 500;">&copy; {{ date('Y') }} UNESA. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>