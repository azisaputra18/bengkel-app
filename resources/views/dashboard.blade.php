@extends('layouts.app')

@section('title', 'Dashboard - BengkelPro')

@section('content')

{{-- Header --}}
<div class="mb-8">
    <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white tracking-tight">
        Welcome back, {{ Auth::user()->name }}! 👋
    </h1>
    <p class="text-gray-500 dark:text-slate-400 mt-2">Pantau status antrian dan kinerja mekanik bengkel hari ini.</p>
</div>

{{-- Stats Grid --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">

    <div class="bg-white dark:bg-[#1e293b] p-6 rounded-[2rem] border border-gray-100 dark:border-slate-800 shadow-sm">
        <div class="w-12 h-12 bg-[#26D4B9]/10 text-[#26D4B9] rounded-2xl flex items-center justify-center text-xl mb-4">
            <i class="fa-solid fa-list-ol"></i>
        </div>
        <p class="text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-1">Total Antrian</p>
        <h3 class="text-4xl font-black text-gray-900 dark:text-white">{{ number_format($totalAntrian) }}</h3>
    </div>

    <div class="bg-white dark:bg-[#1e293b] p-6 rounded-[2rem] border border-gray-100 dark:border-slate-800 shadow-sm">
        <div class="w-12 h-12 bg-blue-500/10 text-blue-500 rounded-2xl flex items-center justify-center text-xl mb-4">
            <i class="fa-solid fa-wrench"></i>
        </div>
        <p class="text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-1">Total Mekanik</p>
        <h3 class="text-4xl font-black text-gray-900 dark:text-white">{{ $mekanikAktif }}</h3>
    </div>

    <div class="bg-white dark:bg-[#1e293b] p-6 rounded-[2rem] border border-gray-100 dark:border-slate-800 shadow-sm">
        <div class="w-12 h-12 bg-emerald-500/10 text-emerald-500 rounded-2xl flex items-center justify-center text-xl mb-4">
            <i class="fa-solid fa-circle-check"></i>
        </div>
        <p class="text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-1">Selesai Hari Ini</p>
        <h3 class="text-4xl font-black text-gray-900 dark:text-white">{{ $selesaiHariIni }}</h3>
    </div>

    <div class="bg-white dark:bg-[#1e293b] p-6 rounded-[2rem] border border-gray-100 dark:border-slate-800 shadow-sm">
        <div class="w-12 h-12 bg-amber-500/10 text-amber-500 rounded-2xl flex items-center justify-center text-xl mb-4">
            <i class="fa-solid fa-hourglass-start"></i>
        </div>
        <p class="text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-1">Menunggu</p>
        <h3 class="text-4xl font-black text-gray-900 dark:text-white">{{ $menunggu }}</h3>
    </div>

</div>

{{-- Chart --}}
<div class="bg-white dark:bg-[#1e293b] p-8 rounded-[2rem] border border-gray-100 dark:border-slate-800 shadow-sm mb-8">
    <div class="flex items-center gap-3 mb-6">
        <div class="w-2 h-2 bg-[#26D4B9] rounded-full"></div>
        <h4 class="font-black text-gray-800 dark:text-white">Grafik Pendapatan 7 Hari Terakhir</h4>
    </div>
    <div class="h-[280px] w-full">
        <canvas id="salesChart"></canvas>
    </div>
</div>

{{-- Bottom Grid --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- Log Aktivitas --}}
    <div class="bg-white dark:bg-[#1e293b] p-8 rounded-[2rem] border border-gray-100 dark:border-slate-800 shadow-sm">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-2 h-2 bg-[#26D4B9] rounded-full"></div>
            <h4 class="font-black text-gray-800 dark:text-white">Log Aktivitas Terbaru</h4>
        </div>
        <div class="space-y-4">
            @forelse($logs as $log)
            <div class="flex items-center gap-4">
                <div class="w-11 h-11 rounded-2xl flex items-center justify-center flex-shrink-0
                    {{ $log->status === 'completed' ? 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-500' :
                       ($log->status === 'processing' ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-500' :
                       'bg-amber-50 dark:bg-amber-900/20 text-amber-500') }}">
                    <i class="fa-solid {{ $log->status === 'completed' ? 'fa-check-double' : ($log->status === 'processing' ? 'fa-user-gear' : 'fa-plus-circle') }}"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-gray-800 dark:text-slate-200 truncate">
                        <span class="font-black uppercase">{{ $log->vehicle_id }}</span>
                        <span class="{{ $log->status === 'completed' ? 'text-emerald-500' : ($log->status === 'processing' ? 'text-blue-500' : 'text-amber-500') }}">
                            @if($log->status === 'completed') selesai dikerjakan
                            @elseif($log->status === 'processing') sedang dikerjakan — {{ $log->mechanic->name ?? '-' }}
                            @else masuk antrian
                            @endif
                        </span>
                    </p>
                    <p class="text-[10px] text-gray-400 dark:text-slate-500 font-medium mt-0.5">
                        {{ $log->updated_at->diffForHumans() }}
                    </p>
                </div>
            </div>
            @empty
            <div class="text-center py-8">
                <i class="fa-solid fa-inbox text-gray-200 dark:text-slate-700 text-3xl mb-3"></i>
                <p class="text-gray-400 dark:text-slate-500 text-sm">Belum ada aktivitas.</p>
            </div>
            @endforelse
        </div>
    </div>

    {{-- Antrian Berikutnya --}}
    <div class="bg-white dark:bg-[#1e293b] p-8 rounded-[2rem] border border-gray-100 dark:border-slate-800 shadow-sm">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-2 h-2 bg-amber-400 rounded-full"></div>
            <h4 class="font-black text-gray-800 dark:text-white">Antrian Berikutnya</h4>
        </div>
        <div class="space-y-3">
            @forelse($nextQueues as $nq)
            <div class="p-4 bg-gray-50 dark:bg-slate-800/40 rounded-2xl border border-gray-100 dark:border-slate-700 flex items-center justify-between hover:border-[#26D4B9]/40 transition-all">
                <div class="flex items-center gap-4">
                    <div class="w-11 h-11 bg-white dark:bg-slate-800 rounded-xl flex items-center justify-center font-black text-[#26D4B9] text-sm shadow-sm border border-gray-100 dark:border-slate-700">
                        {{ sprintf('%03d', $nq->queue_number) }}
                    </div>
                    <div>
                        <p class="text-sm font-black text-gray-800 dark:text-white uppercase">
                            {{ $nq->vehicle_id }}
                            <span class="font-medium normal-case text-gray-500 dark:text-slate-400">— {{ $nq->vehicle_name }}</span>
                        </p>
                        <p class="text-[10px] text-gray-400 dark:text-slate-500 font-bold uppercase tracking-wider mt-0.5">
                            {{ $nq->service->name ?? '-' }} · {{ $nq->mechanic->name ?? '-' }}
                        </p>
                    </div>
                </div>
                <span class="text-[10px] font-black text-gray-400 dark:text-slate-500 bg-white dark:bg-slate-800 px-3 py-1.5 rounded-xl border border-gray-100 dark:border-slate-700 flex-shrink-0">
                    {{ $nq->created_at->format('H:i') }}
                </span>
            </div>
            @empty
            <div class="text-center py-10">
                <i class="fa-solid fa-mug-hot text-gray-200 dark:text-slate-700 text-3xl mb-3"></i>
                <p class="text-gray-400 dark:text-slate-500 text-sm italic">Semua antrian sudah diproses.</p>
            </div>
            @endforelse
        </div>
    </div>

</div>

{{-- Chart Script --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const isDark = document.documentElement.classList.contains('dark');
    const gridColor = isDark ? 'rgba(255,255,255,0.05)' : 'rgba(0,0,0,0.05)';
    const tickColor = isDark ? '#64748b' : '#9ca3af';

    const ctx = document.getElementById('salesChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($labels) !!},
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: {!! json_encode($totals) !!},
                borderColor: '#26D4B9',
                backgroundColor: 'rgba(38, 212, 185, 0.08)',
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#26D4B9',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => 'Rp ' + ctx.raw.toLocaleString('id-ID')
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: gridColor },
                    ticks: {
                        color: tickColor,
                        callback: v => 'Rp ' + v.toLocaleString('id-ID')
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: { color: tickColor }
                }
            }
        }
    });
</script>

@endsection