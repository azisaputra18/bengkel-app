<!-- Hamburger Button (Mobile Only) -->
<button id="sidebar-toggle"
    class="lg:hidden fixed top-4 left-4 z-50 w-10 h-10 bg-white dark:bg-[#1e293b] rounded-xl shadow-lg flex items-center justify-center text-slate-600 dark:text-slate-300 border border-slate-100 dark:border-slate-700">
    <i class="fa-solid fa-bars" id="hamburger-icon"></i>
</button>

<!-- Overlay (Mobile) -->
<div id="sidebar-overlay"
    class="lg:hidden fixed inset-0 bg-black/40 z-30 hidden transition-opacity duration-300"></div>

<!-- Sidebar -->
<aside id="sidebar"
    class="w-72 bg-white dark:bg-[#1e293b] border-r border-slate-100 dark:border-transparent flex flex-col fixed h-full z-40 transition-transform duration-300 shadow-xl dark:shadow-2xl
    -translate-x-full lg:translate-x-0">

    <!-- Logo Area -->
    <div class="p-8 pb-10">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center text-white dark:text-[#1e293b] font-black text-2xl shadow-lg shadow-primary/30">
                <i class="fa-solid fa-wrench"></i>
            </div>
            <div class="flex flex-col">
                <span class="text-xl font-black tracking-tighter text-slate-800 dark:text-white uppercase leading-none">
                    BENGKEL<span class="text-primary">PRO</span>
                </span>
                <span class="text-[9px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mt-1">Management System</span>
            </div>
        </div>
    </div>

    <nav class="flex-1 px-6 space-y-6 overflow-y-auto">

        <!-- MENU UTAMA -->
        <div>
            <p class="px-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] mb-4">Menu Utama</p>
            <div class="space-y-1">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all {{ Request::is('dashboard*') ? 'text-primary bg-slate-50 dark:bg-slate-800/50' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/30 hover:text-primary dark:hover:text-white' }}">
                    <i class="fa-solid fa-table-columns w-5 text-lg"></i>
                    <span class="font-bold text-[15px]">Dashboard</span>
                </a>

                <!-- Dropdown Master Data -->
                <div class="relative">
                    <button onclick="toggleDropdown('master-menu', 'master-arrow')"
                        class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all {{ Request::is('services*') || Request::is('mechanics*') ? 'text-primary' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/30 hover:text-primary dark:hover:text-white' }}">
                        <div class="flex items-center gap-4">
                            <i class="fa-solid fa-database w-5 text-lg"></i>
                            <span class="font-bold text-[15px]">Master Data</span>
                        </div>
                        <i id="master-arrow" class="fa-solid fa-chevron-up text-[10px] transition-transform duration-300 {{ Request::is('services*') || Request::is('mechanics*') ? '' : 'rotate-180' }}"></i>
                    </button>
                    <div id="master-menu" class="submenu-container flex flex-col pl-12 pr-4 space-y-2 {{ Request::is('services*') || Request::is('mechanics*') ? 'submenu-open' : '' }}">
                        <a href="{{ route('services.index') }}"
                            class="py-2 text-[14px] font-bold {{ Request::is('services*') ? 'text-primary' : 'text-slate-500 dark:text-slate-400 hover:text-primary dark:hover:text-white' }}">
                            Layanan Service
                        </a>
                        <a href="{{ route('mechanics.index') }}"
                            class="py-2 text-[14px] font-bold {{ Request::is('mechanics*') ? 'text-primary' : 'text-slate-500 dark:text-slate-400 hover:text-primary dark:hover:text-white' }}">
                            Data Mekanik
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- OPERASIONAL -->
        <div>
            <p class="px-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] mb-4">Operasional</p>
            <div class="space-y-1">
                <a href="{{ route('queues.index') }}"
                    class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all {{ Request::is('queues*') ? 'text-primary bg-slate-50 dark:bg-slate-800/50' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/30 hover:text-primary dark:hover:text-white' }}">
                    <i class="fa-solid fa-list-ol w-5 text-lg"></i>
                    <span class="font-bold text-[15px]">Data Antrean</span>
                </a>

                <a href="/pengerjaan"
                    class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all {{ Request::is('pengerjaan*') ? 'text-primary bg-slate-50 dark:bg-slate-800/50' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/30 hover:text-primary dark:hover:text-white' }}">
                    <i class="fa-solid fa-screwdriver-wrench w-5 text-lg"></i>
                    <span class="font-bold text-[15px]">Pengerjaan</span>
                    @php $processingCount = \App\Models\Queue::where('status', 'processing')->count(); @endphp
                    @if($processingCount > 0)
                    <span class="ml-auto bg-blue-500 text-white text-[10px] px-2 py-1 rounded-lg shadow-lg shadow-blue-500/20 animate-pulse">
                        {{ $processingCount }}
                    </span>
                    @endif
                </a>
            </div>
        </div>

        <!-- ADMINISTRASI -->
        <div>
            <p class="px-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] mb-4">Administrasi</p>
            <div class="space-y-1">
                <a href="{{ route('invoices.index') }}"
                    class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all {{ Request::is('invoices*') ? 'text-primary bg-slate-50 dark:bg-slate-800/50' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/30 hover:text-primary dark:hover:text-white' }}">
                    <i class="fa-solid fa-file-invoice-dollar w-5 text-lg"></i>
                    <span class="font-bold text-[15px]">Invoice / Tagihan</span>
                </a>
            </div>
        </div>

    </nav>

    <!-- Logout -->
    <div class="p-6 border-t border-slate-100 dark:border-slate-800">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full flex items-center justify-center gap-3 px-4 py-4 rounded-2xl bg-slate-50 dark:bg-slate-800/50 text-slate-500 dark:text-slate-400 hover:bg-red-50 dark:hover:bg-red-500/10 hover:text-red-500 transition-all font-bold text-sm">
                <i class="fa-solid fa-power-off"></i>
                <span>Log Out</span>
            </button>
        </form>
    </div>
</aside>

<script>
const sidebar         = document.getElementById('sidebar');
const overlay         = document.getElementById('sidebar-overlay');
const toggleBtn       = document.getElementById('sidebar-toggle');
const hamburgerIcon   = document.getElementById('hamburger-icon');

function openSidebar() {
    sidebar.classList.remove('-translate-x-full');
    overlay.classList.remove('hidden');
    hamburgerIcon.classList.replace('fa-bars', 'fa-xmark');
}

function closeSidebar() {
    sidebar.classList.add('-translate-x-full');
    overlay.classList.add('hidden');
    hamburgerIcon.classList.replace('fa-xmark', 'fa-bars');
}

toggleBtn.addEventListener('click', () => {
    sidebar.classList.contains('-translate-x-full') ? openSidebar() : closeSidebar();
});

overlay.addEventListener('click', closeSidebar);

// Tutup sidebar otomatis saat klik link di mobile
sidebar.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', () => {
        if (window.innerWidth < 1024) closeSidebar();
    });
});
</script>