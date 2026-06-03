@extends('layouts.app')

@section('title', 'Data Antrian - BengkelApp')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

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

    {{-- Modal Konfirmasi Hapus --}}
    <div id="delete-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" id="modal-overlay"></div>
        <div class="relative bg-white dark:bg-[#1e293b] rounded-[2rem] p-8 w-full max-w-sm shadow-2xl border border-gray-100 dark:border-slate-700 z-10">
            <div class="w-14 h-14 bg-red-50 dark:bg-red-900/20 rounded-2xl flex items-center justify-center mx-auto mb-5">
                <i class="fa-solid fa-trash-can text-red-500 text-xl"></i>
            </div>
            <h3 class="text-lg font-black text-gray-800 dark:text-white text-center mb-2">Hapus Antrian?</h3>
            <p class="text-sm text-gray-500 dark:text-slate-400 text-center mb-6">
                Antrian <strong id="modal-queue-name" class="text-gray-800 dark:text-white"></strong> akan dihapus permanen dan tidak bisa dikembalikan.
            </p>
            <div class="flex gap-3">
                <button id="modal-cancel"
                    class="flex-1 py-3 rounded-2xl bg-gray-100 dark:bg-slate-800 text-gray-600 dark:text-slate-300 font-black text-sm uppercase tracking-widest hover:bg-gray-200 dark:hover:bg-slate-700 transition-all">
                    Batal
                </button>
                <form id="modal-form" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-full py-3 rounded-2xl bg-red-500 hover:bg-red-600 text-white font-black text-sm uppercase tracking-widest transition-all active:scale-95">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-10">
        <div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 dark:text-white tracking-tight">Data Antrian</h1>
            <p class="text-gray-500 dark:text-slate-400 mt-2">Pantau dan kelola alur pengerjaan kendaraan secara real-time.</p>
        </div>
        <a href="{{ route('queues.create') }}"
           class="w-full md:w-auto justify-center bg-[#26D4B9] hover:bg-[#20bfa6] text-white px-6 py-4 rounded-2xl font-bold flex items-center gap-2 shadow-xl shadow-[#26D4B9]/20 transition-all hover:-translate-y-1 active:scale-95 text-sm uppercase tracking-wider">
            <i class="fa-solid fa-plus-circle"></i> Tambah Antrian
        </a>
    </div>

    <!-- Stats: Menggunakan grid-cols-1 di mobile agar tidak sesak, atau tetap grid-cols-3 dengan teks kecil -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 mb-8">
        {{-- Card Waiting --}}
        <div class="bg-amber-50 dark:bg-amber-900/10 border border-amber-100 dark:border-amber-900/20 p-4 rounded-3xl flex items-center gap-4">
            <div class="w-12 h-12 shrink-0 bg-amber-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-amber-500/20">
                <i class="fa-solid fa-hourglass-start"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-amber-600/50 uppercase tracking-widest">Menunggu</p>
                <p class="text-xl font-black text-amber-600 dark:text-amber-500">
                    {{ $allQueues->where('status', 'waiting')->count() }} Unit
                </p>
            </div>
        </div>
        {{-- Card Processing --}}
        <div class="bg-blue-50 dark:bg-blue-900/10 border border-blue-100 dark:border-blue-900/20 p-4 rounded-3xl flex items-center gap-4">
            <div class="w-12 h-12 shrink-0 bg-blue-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/20">
                <i class="fa-solid fa-gears"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-blue-600/50 uppercase tracking-widest">Diproses</p>
                <p class="text-xl font-black text-blue-600 dark:text-blue-500">
                    {{ $allQueues->where('status', 'processing')->count() }} Unit
                </p>
            </div>
        </div>
        {{-- Card Completed --}}
        <div class="bg-emerald-50 dark:bg-emerald-900/10 border border-emerald-100 dark:border-emerald-900/20 p-4 rounded-3xl flex items-center gap-4">
            <div class="w-12 h-12 shrink-0 bg-[#26D4B9] text-white rounded-2xl flex items-center justify-center shadow-lg shadow-[#26D4B9]/20">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-[#26D4B9]/50 uppercase tracking-widest">Selesai</p>
                <p class="text-xl font-black text-[#26D4B9]">
                    {{ $allQueues->where('status', 'completed')->count() }} Unit
                </p>
            </div>
        </div>
    </div>

    <!-- Table Container -->
    <div class="bg-white dark:bg-slate-900 rounded-[2rem] md:rounded-[2.5rem] border border-gray-100 dark:border-slate-800 custom-shadow overflow-hidden transition-colors duration-300">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="hidden md:table-row bg-gray-50 dark:bg-slate-800/50 border-b border-gray-50 dark:border-slate-800">
                        <th class="px-6 py-6 text-xs font-black text-gray-400 uppercase tracking-[0.2em]">No</th>
                        <th class="px-6 py-6 text-xs font-black text-gray-400 uppercase tracking-[0.2em]">Customer</th>
                        <th class="px-6 py-6 text-xs font-black text-gray-400 uppercase tracking-[0.2em]">Kendaraan</th>
                        <th class="px-6 py-6 text-xs font-black text-gray-400 uppercase tracking-[0.2em] hidden lg:table-cell">Layanan</th>
                        <th class="px-6 py-6 text-xs font-black text-gray-400 uppercase tracking-[0.2em] hidden lg:table-cell">Mekanik</th>
                        <th class="px-6 py-6 text-xs font-black text-gray-400 uppercase tracking-[0.2em]">Status</th>
                        <th class="px-6 py-6 text-xs font-black text-gray-400 uppercase tracking-[0.2em] text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-slate-800">
                    @forelse($queues as $q)
                    <tr class="flex flex-col md:table-row group hover:bg-gray-50/30 dark:hover:bg-slate-800/30 transition-colors p-4 md:p-0">
                        
                        {{-- No Antrian - Mobile: Floating Badge --}}
                        <td class="px-2 md:px-6 py-2 md:py-6">
                            <div class="flex items-center justify-between md:justify-start">
                                <span class="md:hidden text-xs font-black text-gray-400 uppercase">No. Antrian</span>
                                <span class="w-10 h-10 bg-gray-100 dark:bg-slate-800 text-gray-800 dark:text-slate-200 rounded-xl flex items-center justify-center font-black text-sm">
                                    {{ $q->queue_number }}
                                </span>
                            </div>
                        </td>

                        {{-- Customer --}}
                        <td class="px-2 md:px-6 py-2 md:py-6">
                            <span class="md:hidden text-xs font-black text-gray-400 uppercase block mb-1">Customer</span>
                            <p class="font-bold text-gray-800 dark:text-slate-200">{{ $q->customer_name }}</p>
                            <p class="text-[10px] font-black text-gray-400 dark:text-slate-500">{{ $q->phone }}</p>
                        </td>

                        {{-- Kendaraan --}}
                        <td class="px-2 md:px-6 py-2 md:py-6">
                            <span class="md:hidden text-xs font-black text-gray-400 uppercase block mb-1">Kendaraan</span>
                            <p class="font-bold text-gray-700 dark:text-slate-300 uppercase">{{ $q->vehicle_id }}</p>
                            <p class="text-xs text-gray-400 dark:text-slate-500">{{ $q->vehicle_name }}</p>
                        </td>

                        {{-- Layanan & Mekanik (Stacked on Mobile) --}}
                        <td class="px-2 md:px-6 py-2 md:py-6 lg:table-cell">
                             <div class="flex flex-col md:block">
                                <span class="md:hidden text-xs font-black text-gray-400 uppercase block mb-1">Layanan / Mekanik</span>
                                <span class="text-sm font-medium text-gray-600 dark:text-slate-400 block">
                                    {{ $q->service->name ?? '-' }}
                                </span>
                                <span class="md:hidden text-sm font-bold text-gray-700 dark:text-slate-300 mt-1 block">
                                    Mekanik: {{ $q->mechanic->name ?? '-' }}
                                </span>
                             </div>
                        </td>

                        <td class="px-6 py-6 hidden lg:table-cell">
                            <p class="text-sm font-bold text-gray-700 dark:text-slate-300">
                                <i class="fa-solid fa-user-gear mr-2 text-gray-400"></i>
                                {{ $q->mechanic->name ?? '-' }}
                            </p>
                        </td>

                        {{-- Status Badge --}}
                        <td class="px-2 md:px-6 py-2 md:py-6">
                            <span class="md:hidden text-xs font-black text-gray-400 uppercase block mb-2">Status</span>
                            @php
                                $statusConfig = [
                                    'waiting'    => ['class' => 'bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 border-amber-100 dark:border-amber-900/30', 'label' => 'Menunggu'],
                                    'processing' => ['class' => 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 border-blue-100 dark:border-blue-900/30',   'label' => 'Diproses'],
                                    'completed'  => ['class' => 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-[#26D4B9] border-emerald-100 dark:border-emerald-900/30', 'label' => 'Selesai'],
                                ];
                                $cfg = $statusConfig[$q->status] ?? ['class' => 'bg-gray-50 text-gray-500 border-gray-100', 'label' => $q->status];
                            @endphp
                            <span class="{{ $cfg['class'] }} inline-block px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest border">
                                {{ $cfg['label'] }}
                            </span>
                        </td>

                        {{-- Aksi --}}
                        <td class="px-2 md:px-6 py-4 md:py-6">
                            <div class="flex items-center justify-start md:justify-center gap-2">
                                {{-- Tombol Mulai/Selesai/Invoice tetap sama ... --}}
                                @if($q->status === 'waiting')
                                    <form action="{{ route('queues.start', $q->id) }}" method="POST" class="flex-1 md:flex-none">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all active:scale-95">
                                            <i class="fa-solid fa-play mr-1"></i> Mulai
                                        </button>
                                    </form>
                                @elseif($q->status === 'processing')
                                    <form action="{{ route('queues.finish', $q->id) }}" method="POST" class="flex-1 md:flex-none">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="w-full md:w-auto bg-[#26D4B9] hover:bg-[#20bfa6] text-white px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all active:scale-95">
                                            <i class="fa-solid fa-check mr-1"></i> Selesai
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('invoices.print', $q->id) }}" class="flex-1 md:flex-none text-center bg-gray-100 dark:bg-slate-800 hover:bg-gray-200 dark:hover:bg-slate-700 text-gray-600 dark:text-slate-300 px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">
                                        <i class="fa-solid fa-file-invoice mr-1"></i> Invoice
                                    </a>
                                @endif

                                {{-- MODIFIKASI TOMBOL HAPUS DISINI --}}
                                <button type="button" 
                                    onclick="openDeleteModal('{{ route('queues.destroy', $q->id) }}', '{{ $q->customer_name }}')"
                                    class="w-10 h-10 bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/40 text-red-500 rounded-xl flex items-center justify-center transition-all">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center gap-4">
                                <div class="w-16 h-16 bg-gray-100 dark:bg-slate-800 rounded-3xl flex items-center justify-center">
                                    <i class="fa-solid fa-inbox text-2xl text-gray-300 dark:text-slate-600"></i>
                                </div>
                                <p class="text-gray-400 dark:text-slate-500 font-medium">Belum ada antrian hari ini</p>
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
    const modal = document.getElementById('delete-modal');
    const modalForm = document.getElementById('modal-form');
    const modalQueueName = document.getElementById('modal-queue-name');
    const closeModalBtns = [document.getElementById('modal-cancel'), document.getElementById('modal-overlay')];

    function openDeleteModal(actionUrl, customerName) {
        // Set Action URL Form
        modalForm.action = actionUrl;
        // Set Nama Customer di teks konfirmasi
        modalQueueName.innerText = customerName;
        
        // Tampilkan Modal
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        // Animasi sedikit (opsional)
        document.body.style.overflow = 'hidden'; // Lock scroll
    }

    function closeDeleteModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = 'auto'; // Unlock scroll
    }

    closeModalBtns.forEach(btn => {
        btn.addEventListener('click', closeDeleteModal);
    });

    // Tutup dengan tombol Esc
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeDeleteModal();
        }
    });
</script>
@endsection