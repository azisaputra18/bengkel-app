@extends('layouts.app')

@section('title', 'Pengerjaan Unit - BengkelPro')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6">

    {{-- Flash Message --}}
    @if(session('success'))
    <div class="mb-6 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-900/30 text-emerald-700 dark:text-emerald-400 px-6 py-4 rounded-2xl font-bold text-sm flex items-center gap-3">
        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-900/30 text-red-700 dark:text-red-400 px-6 py-4 rounded-2xl font-bold text-sm flex items-center gap-3">
        <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
    </div>
    @endif

    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8 md:mb-10">
        <div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 dark:text-white tracking-tight">Sedang Dikerjakan</h1>
            <p class="text-gray-500 dark:text-slate-400 mt-2 text-sm">Kendaraan yang saat ini sedang ditangani mekanik.</p>
        </div>
        <div class="w-full md:w-auto bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-900/30 px-5 py-3 rounded-2xl flex md:block justify-between items-center">
            <p class="text-[10px] font-black text-blue-400 uppercase tracking-widest">Sedang Diproses</p>
            <p class="text-xl md:text-2xl font-black text-blue-600 dark:text-blue-400">{{ $workingQueues->count() }} Unit</p>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-slate-900 rounded-[2rem] md:rounded-[2.5rem] border border-gray-100 dark:border-slate-800 custom-shadow transition-colors duration-300">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="hidden md:table-header-group">
                    <tr class="bg-gray-50/50 dark:bg-slate-800/50">
                        <th class="px-6 py-6 text-xs font-black text-gray-400 uppercase tracking-[0.2em]">No</th>
                        <th class="px-6 py-6 text-xs font-black text-gray-400 uppercase tracking-[0.2em]">Data Unit</th>
                        <th class="px-6 py-6 text-xs font-black text-gray-400 uppercase tracking-[0.2em]">Layanan</th>
                        <th class="px-6 py-6 text-xs font-black text-gray-400 uppercase tracking-[0.2em]">Mekanik</th>
                        <th class="px-6 py-6 text-xs font-black text-gray-400 uppercase tracking-[0.2em]">Mulai</th>
                        <th class="px-6 py-6 text-xs font-black text-gray-400 uppercase tracking-[0.2em]">Est. Selesai</th>
                        <th class="px-6 py-6 text-xs font-black text-gray-400 uppercase tracking-[0.2em] text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-50 dark:divide-slate-800">
                    @forelse($workingQueues as $q)
                    <tr class="flex flex-col md:table-row hover:bg-gray-50/30 dark:hover:bg-slate-800/30 transition-colors p-5 md:p-0 border-b md:border-b-0 border-gray-100 dark:border-slate-800">

                        {{-- No --}}
                        <td class="md:px-6 md:py-6 mb-4 md:mb-0">
                            <div class="flex items-center justify-between md:justify-start">
                                <span class="md:hidden text-[10px] font-black text-gray-400 uppercase tracking-widest">No. Antrian</span>
                                <span class="w-10 h-10 bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 rounded-xl flex items-center justify-center font-black text-sm">
                                    {{ $q->queue_number }}
                                </span>
                            </div>
                        </td>

                        {{-- Customer & Kendaraan --}}
                        <td class="md:px-6 md:py-6 mb-4 md:mb-0">
                            <div class="flex items-center justify-between md:block mb-1 md:mb-0">
                                <span class="md:hidden text-[10px] font-black text-gray-400 uppercase tracking-widest">Customer & Unit</span>
                            </div>
                            <p class="font-bold text-gray-800 dark:text-slate-200">{{ $q->customer_name }}</p>
                            <p class="text-[10px] text-gray-400 dark:text-slate-500">{{ $q->phone }}</p>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-[10px] px-2 py-0.5 bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-slate-400 rounded-md font-bold uppercase">{{ $q->vehicle_id }}</span>
                                <span class="text-xs text-gray-400 dark:text-slate-500">{{ $q->vehicle_name }}</span>
                            </div>
                        </td>

                        {{-- Layanan --}}
                        <td class="md:px-6 md:py-6 mb-4 md:mb-0">
                            <div class="flex items-center justify-between md:block mb-1 md:mb-0">
                                <span class="md:hidden text-[10px] font-black text-gray-400 uppercase tracking-widest">Layanan</span>
                            </div>
                            <span class="text-sm font-semibold text-gray-600 dark:text-slate-400">
                                {{ $q->service->name ?? '-' }}
                            </span>
                        </td>

                        {{-- Mekanik --}}
                        <td class="md:px-6 md:py-6 mb-4 md:mb-0">
                            <div class="flex items-center justify-between md:block mb-1 md:mb-0">
                                <span class="md:hidden text-[10px] font-black text-gray-400 uppercase tracking-widest">Mekanik</span>
                            </div>
                            <p class="text-sm font-bold text-gray-700 dark:text-slate-300 flex items-center gap-2">
                                <i class="fa-solid fa-user-gear text-blue-400/50"></i>
                                {{ $q->mechanic->name ?? '-' }}
                            </p>
                        </td>

                        {{-- Waktu Mulai --}}
                        <td class="md:px-6 md:py-6 mb-4 md:mb-0">
                            <div class="flex items-center justify-between md:block mb-1 md:mb-0">
                                <span class="md:hidden text-[10px] font-black text-gray-400 uppercase tracking-widest">Mulai</span>
                            </div>
                           @if($q->start_time)
                                @php
                                    $hariIndo  = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
                                    $bulanIndo = ['','Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
                                    $st = \Carbon\Carbon::parse($q->start_time);
                                    $startTanggal = $hariIndo[$st->dayOfWeek] . ', ' .
                                        $st->format('d') . ' ' .
                                        $bulanIndo[$st->month] . ' ' .
                                        $st->format('Y');
                                @endphp
                                <span class="text-sm font-mono font-black text-blue-600 dark:text-blue-400">
                                    {{ $st->format('H:i') }}
                                </span>
                                <p class="text-[10px] text-blue-400/70 dark:text-blue-500/70 font-bold mt-0.5">
                                    {{ $startTanggal }}
                                </p>
                            @else
                                <span class="text-sm text-gray-400">--:--</span>
                            @endif
                        </td>

                        {{-- Estimasi Selesai --}}
                        <td class="md:px-6 md:py-6 mb-6 md:mb-0">
                            <div class="flex items-center justify-between md:block mb-1 md:mb-0">
                                <span class="md:hidden text-[10px] font-black text-gray-400 uppercase tracking-widest">Est. Selesai</span>
                            </div>

                            @if($q->start_time && $q->service)
                             @php
                                $OPEN_HOUR  = 8;
                                $CLOSE_HOUR = 16;
                                $WORK_HOURS = $CLOSE_HOUR - $OPEN_HOUR;

                                $hariIndo  = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
                                $bulanIndo = ['','Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];

                                $start     = \Carbon\Carbon::parse($q->start_time);
                                $durasiJam = (float)($q->service->duration ?? 1);

                                $jamTutup = $start->copy()
                                    ->setHour($CLOSE_HOUR)->setMinute(0)->setSecond(0);

                                if ($start->gte($jamTutup)) {
                                    $start    = $start->copy()->addDay()
                                        ->setHour($OPEN_HOUR)->setMinute(0)->setSecond(0);
                                    $jamTutup = $start->copy()
                                        ->setHour($CLOSE_HOUR)->setMinute(0)->setSecond(0);
                                }

                                $sisaHariIni = $start->diffInMinutes($jamTutup) / 60;

                                if ($durasiJam <= $sisaHariIni) {
                                    $estSelesai = $start->copy()->addHours($durasiJam);
                                    $lintasHari = false;
                                } else {
                                    $sisaDurasi = $durasiJam - $sisaHariIni;
                                    $estSelesai = $start->copy()->addDay()
                                        ->setHour($OPEN_HOUR)->setMinute(0)->setSecond(0);
                                    while ($sisaDurasi > $WORK_HOURS) {
                                        $sisaDurasi -= $WORK_HOURS;
                                        $estSelesai->addDay();
                                    }
                                    $estSelesai->addHours($sisaDurasi);
                                    $lintasHari = true;
                                }

                                $isLate = $estSelesai->isPast();

                                // Format Indonesia manual
                                $estTanggal = $hariIndo[$estSelesai->dayOfWeek] . ', ' .
                                    $estSelesai->format('d') . ' ' .
                                    $bulanIndo[$estSelesai->month] . ' ' .
                                    $estSelesai->format('Y');
                            @endphp

                            <span class="text-sm font-mono font-black {{ $isLate ? 'text-red-500' : 'text-emerald-600 dark:text-[#26D4B9]' }}">
                                {{ $estSelesai->format('H:i') }}
                            </span>
                            <p class="text-[10px] font-bold mt-0.5 {{ $isLate ? 'text-red-400' : 'text-emerald-500/70 dark:text-[#26D4B9]/70' }}">
                                {{ $estTanggal }}
                            </p>

                            @if($lintasHari && !$isLate)
                                <span class="text-[10px] font-black text-orange-400 bg-orange-50 dark:bg-orange-900/20 px-2 py-0.5 rounded-lg mt-1 inline-block">
                                    <i class="fa-solid fa-calendar-days mr-1"></i> Lanjut besok
                                </span>
                            @endif
                            @if($isLate)
                                <span class="text-[10px] font-black text-red-400 bg-red-50 dark:bg-red-900/20 px-2 py-0.5 rounded-lg mt-1 inline-block">
                                    <i class="fa-solid fa-triangle-exclamation mr-1"></i> Terlambat
                                </span>
                            @endif
                            @else
                                <span class="text-sm text-gray-400">--:--</span>
                            @endif
                        </td>

                        {{-- Aksi --}}
                       <td class="md:px-6 md:py-6">
                            <form action="{{ route('queues.finish', $q->id) }}" method="POST"
                                onsubmit="kirimWA('{{ $q->phone }}', '{{ $q->customer_name }}', '{{ $q->vehicle_id }}', '{{ $q->service->name ?? '' }}')">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="w-full md:w-auto bg-[#26D4B9] hover:bg-[#20bfa6] text-white px-6 py-3 md:py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-lg shadow-[#26D4B9]/20 active:scale-95 flex items-center justify-center gap-2">
                                    <i class="fa-solid fa-check"></i> Selesaikan
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center gap-4">
                                <div class="w-16 h-16 bg-gray-100 dark:bg-slate-800 rounded-3xl flex items-center justify-center">
                                    <i class="fa-solid fa-gears text-2xl text-gray-300 dark:text-slate-600"></i>
                                </div>
                                <p class="text-gray-400 dark:text-slate-500 font-medium">Tidak ada unit yang sedang dikerjakan</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function kirimWA(phone, nama, plat, layanan) {
    // Bersihkan nomor — ganti 0 di depan dengan 62
    let nomor = phone.replace(/\D/g, '');
    if (nomor.startsWith('0')) {
        nomor = '62' + nomor.substring(1);
    }

    const pesan = `Halo ${nama}! 👋\n\nKendaraan Anda dengan nomor plat *${plat}* sudah selesai dikerjakan untuk layanan *${layanan}*.\n\nSilakan datang ke bengkel untuk pengambilan kendaraan.\n\nTerima kasih telah mempercayakan kendaraan Anda kepada kami! 🙏\n\n*BengkelPro*`;

    const url = `https://wa.me/${nomor}?text=${encodeURIComponent(pesan)}`;

    // Buka WA di tab baru
    window.open(url, '_blank');
}
</script>
@endsection