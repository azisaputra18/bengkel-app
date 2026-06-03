@extends('layouts.app')

@section('title', 'Data Invoice - BengkelPro')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6">

    @if(session('success'))
    <div class="mb-6 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-900/30 text-emerald-700 dark:text-emerald-400 px-6 py-4 rounded-2xl font-bold text-sm flex items-center gap-3">
        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
    </div>
    @endif

    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 dark:text-white tracking-tight">Invoice</h1>
            <p class="text-gray-500 dark:text-slate-400 mt-2 text-sm">Riwayat transaksi dan laporan pendapatan bengkel.</p>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
        <div class="bg-emerald-50 dark:bg-emerald-900/10 border border-emerald-100 dark:border-emerald-900/20 p-5 rounded-3xl flex items-center gap-4">
            <div class="w-12 h-12 bg-[#26D4B9] text-white rounded-2xl flex items-center justify-center shadow-lg shadow-[#26D4B9]/20 flex-shrink-0">
                <i class="fa-solid fa-file-invoice"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Total Invoice</p>
                <p class="text-xl font-black text-gray-800 dark:text-white">{{ $totalCount }} Transaksi</p>
            </div>
        </div>
        <div class="bg-blue-50 dark:bg-blue-900/10 border border-blue-100 dark:border-blue-900/20 p-5 rounded-3xl flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/20 flex-shrink-0">
                <i class="fa-solid fa-money-bill-wave"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Total Pendapatan</p>
                <p class="text-lg font-black text-gray-800 dark:text-white">
                    Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                </p>
            </div>
        </div>
        <div class="bg-amber-50 dark:bg-amber-900/10 border border-amber-100 dark:border-amber-900/20 p-5 rounded-3xl flex items-center gap-4">
            <div class="w-12 h-12 bg-amber-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-amber-500/20 flex-shrink-0">
                <i class="fa-solid fa-calendar-day"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Pendapatan Hari Ini</p>
                <p class="text-lg font-black text-gray-800 dark:text-white">
                    Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}
                </p>
            </div>
        </div>
    </div>

    <!-- Filter -->
    <div class="bg-white dark:bg-[#1e293b] p-6 rounded-[2rem] border border-gray-100 dark:border-slate-800 shadow-sm mb-6">
        <form method="GET" action="{{ route('invoices.index') }}">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                {{-- Filter Periode --}}
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block">Periode</label>
                    <div class="relative">
                        <select name="filter" class="w-full bg-gray-50 dark:bg-slate-800 border-none rounded-xl py-3 px-4 text-sm font-bold text-gray-700 dark:text-white focus:ring-2 focus:ring-[#26D4B9] outline-none appearance-none">
                            <option value="">Semua Waktu</option>
                            <option value="today" {{ request('filter') == 'today' ? 'selected' : '' }}>Hari Ini</option>
                            <option value="week"  {{ request('filter') == 'week'  ? 'selected' : '' }}>Minggu Ini</option>
                            <option value="month" {{ request('filter') == 'month' ? 'selected' : '' }}>Bulan Ini</option>
                            <option value="year"  {{ request('filter') == 'year'  ? 'selected' : '' }}>Tahun Ini</option>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
                    </div>
                </div>

                {{-- Filter Spesialisasi --}}
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block">Spesialisasi</label>
                    <div class="relative">
                        <select name="specialization" class="w-full bg-gray-50 dark:bg-slate-800 border-none rounded-xl py-3 px-4 text-sm font-bold text-gray-700 dark:text-white focus:ring-2 focus:ring-[#26D4B9] outline-none appearance-none">
                            <option value="">Semua Layanan</option>
                            @foreach($specializations as $spec)
                                <option value="{{ $spec->specialization }}"
                                    {{ request('specialization') == $spec->specialization ? 'selected' : '' }}>
                                    {{ $spec->name }}
                                </option>
                            @endforeach
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
                    </div>
                </div>

                {{-- Tampilkan Per Halaman --}}
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block">Tampilkan</label>
                    <div class="relative">
                        <select name="per_page" class="w-full bg-gray-50 dark:bg-slate-800 border-none rounded-xl py-3 px-4 text-sm font-bold text-gray-700 dark:text-white focus:ring-2 focus:ring-[#26D4B9] outline-none appearance-none">
                            @foreach([10, 30, 50, 100] as $n)
                                <option value="{{ $n }}" {{ request('per_page', 10) == $n ? 'selected' : '' }}>
                                    {{ $n }} Data
                                </option>
                            @endforeach
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
                    </div>
                </div>

                 {{-- Tombol Filter + Reset --}}
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-transparent uppercase tracking-widest block">Aksi</label>
                    <div class="flex gap-2">
                        <button type="submit"
                            class="flex-1 bg-[#26D4B9] text-white py-3 rounded-xl font-black text-xs uppercase tracking-widest hover:bg-[#20bfa6] transition-all shadow-md shadow-[#26D4B9]/20 flex items-center justify-center gap-2">
                            <i class="fa-solid fa-filter"></i> Filter
                        </button>
                        @if(request()->hasAny(['filter', 'specialization', 'per_page']))
                        <a href="{{ route('invoices.index') }}"
                            class="bg-gray-100 dark:bg-slate-800 text-gray-500 dark:text-slate-400 px-4 py-3 rounded-xl font-black text-xs uppercase tracking-widest hover:bg-gray-200 dark:hover:bg-slate-700 transition-all flex items-center justify-center">
                            <i class="fa-solid fa-xmark"></i>
                        </a>
                        @endif
                    </div>
                </div>

                {{-- Tombol Export Excel — TARUH DI SINI --}}
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-transparent uppercase tracking-widest block">Export</label>
                    <a href="{{ route('invoices.export', request()->query()) }}"
                        class="w-full bg-emerald-500 hover:bg-emerald-600 text-white py-3 rounded-xl font-black text-xs uppercase tracking-widest transition-all shadow-md shadow-emerald-500/20 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-file-excel"></i> Export Excel
                    </a>
                </div>

            </div>

            {{-- Info filter aktif --}}
            @if(request()->hasAny(['filter', 'specialization']))
            <div class="mt-4 flex flex-wrap gap-2">
                @if(request('filter'))
                <span class="bg-[#26D4B9]/10 text-[#26D4B9] px-3 py-1 rounded-lg text-xs font-black border border-[#26D4B9]/20 flex items-center gap-1">
                    <i class="fa-solid fa-calendar text-xs"></i>
                    {{ ['today' => 'Hari Ini', 'week' => 'Minggu Ini', 'month' => 'Bulan Ini', 'year' => 'Tahun Ini'][request('filter')] ?? '' }}
                </span>
                @endif
                @if(request('specialization'))
                <span class="bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 px-3 py-1 rounded-lg text-xs font-black border border-blue-100 dark:border-blue-900/30 flex items-center gap-1">
                    <i class="fa-solid fa-wrench text-xs"></i>
                    {{ $specializations->firstWhere('specialization', request('specialization'))?->name ?? request('specialization') }}
                </span>
                @endif
                <span class="bg-gray-100 dark:bg-slate-800 text-gray-500 dark:text-slate-400 px-3 py-1 rounded-lg text-xs font-black flex items-center gap-1">
                    <i class="fa-solid fa-list text-xs"></i>
                    {{ $totalCount }} hasil ditemukan
                </span>
            </div>
            @endif
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-[#1e293b] rounded-[2rem] md:rounded-[2.5rem] border border-gray-100 dark:border-slate-800 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="hidden md:table-header-group">
                    <tr class="bg-gray-50/50 dark:bg-slate-800/50">
                        <th class="px-6 py-6 text-xs font-black text-gray-400 uppercase tracking-[0.2em]">Invoice</th>
                        <th class="px-6 py-6 text-xs font-black text-gray-400 uppercase tracking-[0.2em]">Customer</th>
                        <th class="px-6 py-6 text-xs font-black text-gray-400 uppercase tracking-[0.2em]">Kendaraan</th>
                        <th class="px-6 py-6 text-xs font-black text-gray-400 uppercase tracking-[0.2em]">Layanan</th>
                        <th class="px-6 py-6 text-xs font-black text-gray-400 uppercase tracking-[0.2em]">Waktu</th>
                        <th class="px-6 py-6 text-xs font-black text-gray-400 uppercase tracking-[0.2em]">Total</th>
                        <th class="px-6 py-6 text-xs font-black text-gray-400 uppercase tracking-[0.2em] text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-slate-800">
                    @forelse($invoices as $i)
                    <tr class="flex flex-col md:table-row p-5 md:p-0 hover:bg-gray-50/30 dark:hover:bg-slate-800/30 transition-colors border-b md:border-b-0 border-gray-100 dark:border-slate-800">

                        {{-- Invoice --}}
                        <td class="md:px-6 md:py-6 flex justify-between items-center md:table-cell">
                            <span class="md:hidden text-[10px] font-black text-gray-400 uppercase tracking-widest">ID Invoice</span>
                            <span class="text-sm font-black text-[#26D4B9]">
                                #{{ str_pad($i->id, 5, '0', STR_PAD_LEFT) }}
                            </span>
                        </td>

                        {{-- Customer --}}
                        <td class="md:px-6 md:py-6 mt-3 md:mt-0 flex justify-between items-start md:table-cell">
                            <span class="md:hidden text-[10px] font-black text-gray-400 uppercase tracking-widest">Customer</span>
                            <div class="text-right md:text-left">
                                <p class="font-bold text-gray-800 dark:text-slate-200 text-sm">{{ $i->customer_name }}</p>
                                <p class="text-[10px] text-gray-400 dark:text-slate-500 font-bold">{{ $i->phone }}</p>
                            </div>
                        </td>

                        {{-- Kendaraan --}}
                        <td class="md:px-6 md:py-6 mt-2 md:mt-0 flex justify-between items-start md:table-cell">
                            <span class="md:hidden text-[10px] font-black text-gray-400 uppercase tracking-widest">Unit</span>
                            <div class="text-right md:text-left">
                                <p class="font-bold text-gray-700 dark:text-slate-300 uppercase text-sm">{{ $i->vehicle_id }}</p>
                                <p class="text-xs text-gray-400 dark:text-slate-500">{{ $i->vehicle_name }}</p>
                            </div>
                        </td>

                        {{-- Layanan --}}
                        <td class="md:px-6 md:py-6 mt-2 md:mt-0 flex justify-between items-start md:table-cell">
                            <span class="md:hidden text-[10px] font-black text-gray-400 uppercase tracking-widest">Layanan</span>
                            <div class="text-right md:text-left">
                                <p class="text-sm font-bold text-gray-700 dark:text-slate-300">{{ $i->service->name ?? '-' }}</p>
                                <p class="text-[10px] text-gray-400 dark:text-slate-500 font-bold uppercase mt-0.5">
                                    <i class="fa-solid fa-wrench mr-1"></i>{{ $i->mechanic->name ?? '-' }}
                                </p>
                            </div>
                        </td>

                        {{-- Waktu --}}
                        <td class="md:px-6 md:py-6 mt-2 md:mt-0 flex justify-between items-start md:table-cell">
                            <span class="md:hidden text-[10px] font-black text-gray-400 uppercase tracking-widest">Durasi</span>
                            <div class="text-right md:text-left">
                                <p class="text-sm font-mono font-bold text-gray-700 dark:text-slate-300">
                                    {{ $i->start_time ? \Carbon\Carbon::parse($i->start_time)->format('H:i') : '--:--' }}
                                    <span class="text-gray-300 mx-1">→</span>
                                    {{ $i->end_time ? \Carbon\Carbon::parse($i->end_time)->format('H:i') : '--:--' }}
                                </p>
                                @if($i->start_time && $i->end_time)
                                <p class="text-[10px] text-[#26D4B9] font-bold mt-0.5">
                                    {{ \Carbon\Carbon::parse($i->start_time)->diffForHumans($i->end_time, true) }}
                                </p>
                                @endif
                            </div>
                        </td>

                        {{-- Total --}}
                        <td class="md:px-6 md:py-6 mt-2 md:mt-0 flex justify-between items-center md:table-cell bg-gray-50/50 dark:bg-slate-800/50 md:bg-transparent -mx-5 px-5 py-3 md:mx-0 md:p-6 border-y border-gray-100 dark:border-slate-800 md:border-none">
                            <span class="md:hidden text-[10px] font-black text-gray-400 uppercase tracking-widest">Total</span>
                            <p class="text-base md:text-sm font-black text-emerald-600 dark:text-[#26D4B9]">
                                Rp {{ number_format($i->total_price, 0, ',', '.') }}
                            </p>
                        </td>

                        {{-- Aksi --}}
                        <td class="md:px-6 md:py-6 mt-3 md:mt-0 flex justify-center md:table-cell">
                            <a href="{{ route('invoices.print', $i->id) }}"
                                class="w-full md:w-auto bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/40 text-blue-600 dark:text-blue-400 px-6 py-3 md:py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all flex items-center justify-center gap-2">
                                <i class="fa-solid fa-print"></i> Cetak
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center gap-4">
                                <div class="w-16 h-16 bg-gray-100 dark:bg-slate-800 rounded-3xl flex items-center justify-center">
                                    <i class="fa-solid fa-file-invoice text-2xl text-gray-300 dark:text-slate-600"></i>
                                </div>
                                <p class="text-gray-400 dark:text-slate-500 font-medium">Belum ada invoice</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($invoices->hasPages())
        <div class="px-6 py-5 border-t border-gray-50 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-4">
            {{-- Info --}}
            <p class="text-xs font-bold text-gray-400 dark:text-slate-500">
                Menampilkan {{ $invoices->firstItem() }}–{{ $invoices->lastItem() }}
                dari {{ $invoices->total() }} data
            </p>

            {{-- Tombol Halaman --}}
            <div class="flex items-center gap-1">
                {{-- Prev --}}
                @if($invoices->onFirstPage())
                    <span class="w-9 h-9 flex items-center justify-center rounded-xl bg-gray-100 dark:bg-slate-800 text-gray-300 dark:text-slate-600 cursor-not-allowed">
                        <i class="fa-solid fa-chevron-left text-xs"></i>
                    </span>
                @else
                    <a href="{{ $invoices->previousPageUrl() }}"
                        class="w-9 h-9 flex items-center justify-center rounded-xl bg-gray-100 dark:bg-slate-800 text-gray-500 dark:text-slate-400 hover:bg-[#26D4B9] hover:text-white transition-all">
                        <i class="fa-solid fa-chevron-left text-xs"></i>
                    </a>
                @endif

                {{-- Nomor Halaman --}}
                @foreach($invoices->getUrlRange(1, $invoices->lastPage()) as $page => $url)
                    @if($page == $invoices->currentPage())
                        <span class="w-9 h-9 flex items-center justify-center rounded-xl bg-[#26D4B9] text-white font-black text-xs">
                            {{ $page }}
                        </span>
                    @elseif($page == 1 || $page == $invoices->lastPage() || abs($page - $invoices->currentPage()) <= 1)
                        <a href="{{ $url }}"
                            class="w-9 h-9 flex items-center justify-center rounded-xl bg-gray-100 dark:bg-slate-800 text-gray-500 dark:text-slate-400 hover:bg-[#26D4B9] hover:text-white transition-all font-bold text-xs">
                            {{ $page }}
                        </a>
                    @elseif(abs($page - $invoices->currentPage()) == 2)
                        <span class="w-9 h-9 flex items-center justify-center text-gray-400 text-xs font-bold">...</span>
                    @endif
                @endforeach

                {{-- Next --}}
                @if($invoices->hasMorePages())
                    <a href="{{ $invoices->nextPageUrl() }}"
                        class="w-9 h-9 flex items-center justify-center rounded-xl bg-gray-100 dark:bg-slate-800 text-gray-500 dark:text-slate-400 hover:bg-[#26D4B9] hover:text-white transition-all">
                        <i class="fa-solid fa-chevron-right text-xs"></i>
                    </a>
                @else
                    <span class="w-9 h-9 flex items-center justify-center rounded-xl bg-gray-100 dark:bg-slate-800 text-gray-300 dark:text-slate-600 cursor-not-allowed">
                        <i class="fa-solid fa-chevron-right text-xs"></i>
                    </span>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
@endsection