<header class="bg-white/80 dark:bg-darkCard/80 border-b border-slate-100 dark:border-slate-800 px-10 py-5 sticky top-0 z-30 backdrop-blur-xl flex justify-between items-center transition-colors">
    
    <div class="flex items-center gap-4">
        <div class="w-1.5 h-6 bg-primary rounded-full"></div>

        <h2 class="text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.3em]">
            @yield('page_title', 'Overview')
        </h2>
    </div>

    <div class="flex items-center gap-4">

        <!-- Theme Toggle -->
        <button onclick="handleThemeToggle()" 
            class="w-11 h-11 flex items-center justify-center rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-500 dark:text-primary border border-transparent hover:border-slate-200 dark:hover:border-slate-700 transition-all">

            <i id="nav-theme-icon" class="fa-solid fa-moon text-lg"></i>
        </button>

        <!-- User Profile -->
        <div class="flex items-center gap-4 pl-4 border-l border-slate-100 dark:border-slate-800">

            <a href="{{ route('profile.edit') }}" class="group flex items-center gap-4 pl-4 border-l border-slate-100 dark:border-slate-800 hover:opacity-80 transition-all">
    <div class="text-right hidden sm:block">
        <p class="text-xs font-black text-slate-900 dark:text-white leading-none group-hover:text-[#26D4B9] transition-colors">
            {{ Auth::user()->name }}
        </p>
        <p class="text-[9px] text-[#26D4B9] font-bold uppercase tracking-wider mt-1">
            {{ Auth::user()->role ?? 'Administrator' }}
        </p>
    </div>

    <div class="w-11 h-11 rounded-xl bg-[#26D4B9] flex items-center justify-center text-white font-black shadow-lg shadow-[#26D4B9]/20 group-hover:scale-105 transition-transform">
        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
    </div>
</a>

        </div>
    </div>
</header>

<script>
    function updateNavbarIcon(isDark) {
        const icon = document.getElementById('nav-theme-icon');

        if (icon) {
            icon.className = isDark
                ? 'fa-solid fa-sun text-lg'
                : 'fa-solid fa-moon text-lg';
        }
    }

    updateNavbarIcon(document.documentElement.classList.contains('dark'));

    window.addEventListener('theme-changed', (e) => {
        updateNavbarIcon(e.detail.isDark);
    });
</script>