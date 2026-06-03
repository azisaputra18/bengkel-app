<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') - BengkelPro</title>

    <!-- Fonts & Icons -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('logo.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tailwind CSS Config -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: { primary: '#26D4B9', darkBg: '#0f172a', darkCard: '#1e293b' }
                }
            }
        }

        // Logic Dark Mode (Cegah Flicker)
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; transition: background-color 0.3s ease; }
        .sidebar-item-active { background-color: #26D4B9; color: white !important; box-shadow: 0 10px 15px -3px rgba(38, 212, 185, 0.3); }
        .submenu-container { max-height: 0; overflow: hidden; transition: all 0.3s ease-out; opacity: 0; }
        .submenu-open { max-height: 500px; opacity: 1; margin-top: 0.5rem; }
        .rotate-icon { transform: rotate(180deg); }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen bg-[#F8FAFC] dark:bg-darkBg text-slate-800 dark:text-slate-100 antialiased">

    <div class="flex min-h-screen">

        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Main Wrapper -->
       <div class="flex-1 lg:ml-72 flex flex-col min-h-screen relative">
            <!-- Navbar -->
            @include('layouts.navbar')

            <!-- Area Konten Utama -->
           <main class="px-4 py-6 flex-1">
                @yield('content')
            </main>

            <!-- Footer -->
            @include('layouts.footer')
        </div>
    </div>

    <!-- Scripts Global -->
    <script>
        function handleThemeToggle() {
            const html = document.documentElement;
            html.classList.toggle('dark');
            const isDark = html.classList.contains('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            window.dispatchEvent(new CustomEvent('theme-changed', { detail: { isDark } }));
        }

        function toggleDropdown(menuId, arrowId) {
            const menu = document.getElementById(menuId);
            const arrow = document.getElementById(arrowId);
            menu.classList.toggle('submenu-open');
            arrow.classList.toggle('rotate-icon');
        }
    </script>
    @stack('scripts')
</body>
</html>