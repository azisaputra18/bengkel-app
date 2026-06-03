@extends('layouts.app')

@section('title', 'Tambah Antrian Baru - BengkelApp')

@section('content')
<div class="max-w-5xl mx-auto px-2">

    {{-- Flash Error --}}
    @if(session('error'))
    <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400 px-6 py-4 rounded-2xl font-bold text-sm flex items-center gap-3">
        <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
    </div>
    @endif

    @if($errors->any())
    <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400 px-6 py-4 rounded-2xl font-bold text-sm">
        <p class="flex items-center gap-2 mb-2"><i class="fa-solid fa-circle-exclamation"></i> Mohon periksa form:</p>
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)
                <li class="text-xs">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Header -->
    <div class="mb-10">
        <a href="{{ route('queues.index') }}"
           class="text-[#26D4B9] font-bold text-sm flex items-center gap-2 mb-4 hover:gap-3 transition-all w-fit">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Antrian
        </a>
        <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white tracking-tight">Tambah Antrian</h1>
        <p class="text-gray-500 dark:text-slate-400 mt-2 text-sm">Isi data pelanggan dan kendaraan untuk mendaftarkan antrian baru.</p>
    </div>

    <form action="{{ route('queues.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- ===== KOLOM KIRI ===== -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Card: Informasi Pelanggan -->
                <div class="bg-white dark:bg-[#1e293b] rounded-[2rem] p-8 border border-gray-100 dark:border-slate-800 shadow-sm">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-blue-50 dark:bg-blue-500/10 text-blue-500 rounded-xl flex items-center justify-center">
                            <i class="fa-solid fa-user text-sm"></i>
                        </div>
                        <div>
                            <h3 class="text-base font-black text-gray-800 dark:text-white">Informasi Pelanggan</h3>
                            <p class="text-[11px] text-gray-400 dark:text-slate-500">Nama dan nomor yang bisa dihubungi</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest">
                                Nama Lengkap <span class="text-red-400">*</span>
                            </label>
                            <input type="text" name="customer_name" required
                                value="{{ old('customer_name') }}"
                                placeholder="Contoh: Budi Santoso"
                                class="w-full bg-gray-50 dark:bg-slate-800 border-none rounded-2xl px-5 py-4 text-sm font-medium text-gray-800 dark:text-white placeholder-gray-300 dark:placeholder-slate-600 focus:ring-2 focus:ring-[#26D4B9] transition-all outline-none">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest">
                                Nomor WhatsApp <span class="text-red-400">*</span>
                            </label>
                            <input type="text" name="phone" required
                                value="{{ old('phone') }}"
                                placeholder="Contoh: 08123456789"
                                class="w-full bg-gray-50 dark:bg-slate-800 border-none rounded-2xl px-5 py-4 text-sm font-medium text-gray-800 dark:text-white placeholder-gray-300 dark:placeholder-slate-600 focus:ring-2 focus:ring-[#26D4B9] transition-all outline-none">
                        </div>
                    </div>
                </div>

                <!-- Card: Detail Kendaraan -->
                <div class="bg-white dark:bg-[#1e293b] rounded-[2rem] p-8 border border-gray-100 dark:border-slate-800 shadow-sm">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-purple-50 dark:bg-purple-500/10 text-purple-500 rounded-xl flex items-center justify-center">
                            <i class="fa-solid fa-car text-sm"></i>
                        </div>
                        <div>
                            <h3 class="text-base font-black text-gray-800 dark:text-white">Detail Kendaraan</h3>
                            <p class="text-[11px] text-gray-400 dark:text-slate-500">Identitas kendaraan yang akan diservis</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest">
                                Nomor Plat <span class="text-red-400">*</span>
                            </label>
                            <input type="text" name="vehicle_id" required
                                value="{{ old('vehicle_id') }}"
                                placeholder="Contoh: B 1234 XY"
                                class="w-full bg-gray-50 dark:bg-slate-800 border-none rounded-2xl px-5 py-4 text-sm font-black text-gray-800 dark:text-white placeholder-gray-300 dark:placeholder-slate-600 focus:ring-2 focus:ring-[#26D4B9] transition-all outline-none uppercase">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest">
                                Merk & Tipe Mobil <span class="text-red-400">*</span>
                            </label>
                            <input type="text" name="vehicle_name" required
                                value="{{ old('vehicle_name') }}"
                                placeholder="Contoh: Toyota Avanza"
                                class="w-full bg-gray-50 dark:bg-slate-800 border-none rounded-2xl px-5 py-4 text-sm font-medium text-gray-800 dark:text-white placeholder-gray-300 dark:placeholder-slate-600 focus:ring-2 focus:ring-[#26D4B9] transition-all outline-none">
                        </div>
                    </div>
                </div>

                <!-- Card: Estimasi Biaya -->
                <div class="bg-white dark:bg-[#1e293b] rounded-[2rem] p-8 border border-gray-100 dark:border-slate-800 shadow-sm">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-emerald-50 dark:bg-emerald-500/10 text-emerald-500 rounded-xl flex items-center justify-center">
                            <i class="fa-solid fa-money-bill-wave text-sm"></i>
                        </div>
                        <div>
                            <h3 class="text-base font-black text-gray-800 dark:text-white">Estimasi Biaya</h3>
                            <p class="text-[11px] text-gray-400 dark:text-slate-500">Perkiraan total biaya servis</p>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest">
                            Total Harga (Rp) <span class="text-red-400">*</span>
                        </label>
                        <div class="relative w-full md:w-2/3">
                            <span class="absolute left-5 top-1/2 -translate-y-1/2 text-sm font-black text-gray-400 dark:text-slate-500">Rp</span>
                            <input type="number" name="total_price" required
                                value="{{ old('total_price') }}"
                                placeholder="0"
                                class="w-full bg-gray-50 dark:bg-slate-800 border-none rounded-2xl pl-12 pr-5 py-4 text-sm font-black text-gray-800 dark:text-white placeholder-gray-300 dark:placeholder-slate-600 focus:ring-2 focus:ring-[#26D4B9] transition-all outline-none">
                        </div>
                    </div>
                </div>

            </div>

            <!-- ===== KOLOM KANAN ===== -->
            <div class="space-y-6">
                <div class="bg-white dark:bg-[#1e293b] rounded-[2rem] p-8 border border-gray-100 dark:border-slate-800 shadow-sm sticky top-8">
                    <h3 class="text-base font-black text-gray-800 dark:text-white mb-6">Penugasan Mekanik</h3>

                    <div class="space-y-5">

                        <!-- Pilih Layanan -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest">
                                Jenis Service <span class="text-red-400">*</span>
                            </label>
                            <div class="relative">
                                <select name="service_id" id="service_select" required
                                    class="w-full bg-gray-50 dark:bg-slate-800 border-none rounded-2xl px-5 py-4 text-sm font-bold text-gray-800 dark:text-white focus:ring-2 focus:ring-[#26D4B9] appearance-none cursor-pointer outline-none transition-all">
                                    <option value="" disabled selected>-- Pilih Layanan --</option>
                                    @foreach($services as $s)
                                        <option value="{{ $s->id }}" {{ old('service_id') == $s->id ? 'selected' : '' }}>
                                            {{ $s->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <i class="fa-solid fa-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
                            </div>
                        </div>

                        <!-- Mekanik Auto-Assign -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest">
                                Mekanik Terpilih
                            </label>
                            <input type="hidden" name="mechanic_id" id="mechanic_id_input" value="{{ old('mechanic_id') }}">
                            <div id="mechanic_box"
                                class="w-full bg-gray-50 dark:bg-slate-800 rounded-2xl px-5 py-4 flex items-center gap-3 min-h-[56px] transition-all">
                                <div id="mechanic_icon" class="w-7 h-7 rounded-lg bg-gray-200 dark:bg-slate-700 flex items-center justify-center flex-shrink-0">
                                    <i class="fa-solid fa-user-gear text-xs text-gray-400 dark:text-slate-500"></i>
                                </div>
                                <span id="mechanic_name_display"
                                    class="text-sm font-bold text-gray-400 dark:text-slate-500 italic">
                                    Menunggu pilihan service...
                                </span>
                            </div>
                        </div>

                        <hr class="border-gray-100 dark:border-slate-700">

                        <!-- Ringkasan singkat -->
                        <div id="summary_box" class="hidden bg-gray-50 dark:bg-slate-800 rounded-2xl p-4 space-y-2">
                            <p class="text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-3">Ringkasan</p>
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-gray-500 dark:text-slate-400">Service</span>
                                <span id="summary_service" class="text-xs font-bold text-gray-700 dark:text-slate-300">-</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-gray-500 dark:text-slate-400">Mekanik</span>
                                <span id="summary_mechanic" class="text-xs font-bold text-gray-700 dark:text-slate-300">-</span>
                            </div>
                        </div>

                        <button type="submit" id="submit_btn"
                            class="w-full bg-[#26D4B9] hover:bg-[#20bfa6] text-white py-4 rounded-2xl font-black uppercase tracking-widest shadow-lg shadow-[#26D4B9]/20 transition-all active:scale-95 flex items-center justify-center gap-2 text-sm">
                            <i class="fa-solid fa-plus-circle"></i>
                            Masuk Antrian
                        </button>

                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

<script>
const serviceSelect   = document.getElementById('service_select');
const mechInput       = document.getElementById('mechanic_id_input');
const mechDisplay     = document.getElementById('mechanic_name_display');
const mechBox         = document.getElementById('mechanic_box');
const mechIcon        = document.getElementById('mechanic_icon');
const summaryBox      = document.getElementById('summary_box');
const summaryService  = document.getElementById('summary_service');
const summaryMechanic = document.getElementById('summary_mechanic');

// Helper: set state mekanik box
function setMechanicState(state, name = '') {
    mechBox.className = 'w-full rounded-2xl px-5 py-4 flex items-center gap-3 min-h-[56px] transition-all';

    if (state === 'loading') {
        mechBox.classList.add('bg-gray-50', 'dark:bg-slate-800');
        mechIcon.className = 'w-7 h-7 rounded-lg bg-gray-200 dark:bg-slate-700 flex items-center justify-center flex-shrink-0';
        mechIcon.innerHTML = '<i class="fa-solid fa-spinner fa-spin text-xs text-gray-400"></i>';
        mechDisplay.className = 'text-sm font-bold text-gray-400 dark:text-slate-500 italic';
        mechDisplay.textContent = 'Mencari mekanik...';

    } else if (state === 'success') {
        mechBox.classList.add('bg-[#26D4B9]/10', 'dark:bg-[#26D4B9]/10', 'ring-1', 'ring-[#26D4B9]/30');
        mechIcon.className = 'w-7 h-7 rounded-lg bg-[#26D4B9] flex items-center justify-center flex-shrink-0';
        mechIcon.innerHTML = '<i class="fa-solid fa-user-gear text-xs text-white"></i>';
        mechDisplay.className = 'text-sm font-bold text-[#26D4B9]';
        mechDisplay.textContent = name;

    } else if (state === 'warning') {
        mechBox.classList.add('bg-orange-50', 'dark:bg-orange-900/10', 'ring-1', 'ring-orange-200', 'dark:ring-orange-800');
        mechIcon.className = 'w-7 h-7 rounded-lg bg-orange-400 flex items-center justify-center flex-shrink-0';
        mechIcon.innerHTML = '<i class="fa-solid fa-triangle-exclamation text-xs text-white"></i>';
        mechDisplay.className = 'text-sm font-bold text-orange-500';
        mechDisplay.textContent = name;

    } else if (state === 'error') {
        mechBox.classList.add('bg-red-50', 'dark:bg-red-900/10', 'ring-1', 'ring-red-200', 'dark:ring-red-800');
        mechIcon.className = 'w-7 h-7 rounded-lg bg-red-400 flex items-center justify-center flex-shrink-0';
        mechIcon.innerHTML = '<i class="fa-solid fa-xmark text-xs text-white"></i>';
        mechDisplay.className = 'text-sm font-bold text-red-500';
        mechDisplay.textContent = name;

    } else {
        mechBox.classList.add('bg-gray-50', 'dark:bg-slate-800');
        mechIcon.className = 'w-7 h-7 rounded-lg bg-gray-200 dark:bg-slate-700 flex items-center justify-center flex-shrink-0';
        mechIcon.innerHTML = '<i class="fa-solid fa-user-gear text-xs text-gray-400"></i>';
        mechDisplay.className = 'text-sm font-bold text-gray-400 dark:text-slate-500 italic';
        mechDisplay.textContent = 'Menunggu pilihan service...';
    }
}

serviceSelect.addEventListener('change', function() {
    const serviceId = this.value;
    const serviceText = this.options[this.selectedIndex].text;

    setMechanicState('loading');
    mechInput.value = '';
    summaryBox.classList.add('hidden');

    fetch(`/api/get-next-mechanic/${serviceId}`)
        .then(r => r.json())
        .then(data => {
            if (!data.success) {
                setMechanicState('error', data.message || 'Tidak ada mekanik tersedia');
                mechInput.value = '';
                return;
            }

            if (data.id) {
                mechInput.value = data.id;

                if (data.warning) {
                    setMechanicState('warning', `${data.name} — ${data.warning}`);
                } else {
                    const queueInfo = data.active_queues > 0
                        ? ` (${data.active_queues} antrian aktif)`
                        : '';
                    setMechanicState('success', data.name + queueInfo);
                }

                // Tampilkan ringkasan
                summaryService.textContent  = serviceText;
                summaryMechanic.textContent = data.name;
                summaryBox.classList.remove('hidden');

            } else {
                setMechanicState('error', 'Tidak ada mekanik cocok');
                mechInput.value = '';
            }
        })
        .catch(() => {
            setMechanicState('error', 'Gagal mengambil data mekanik');
            mechInput.value = '';
        });
});

// Submit — service wajib dipilih, mechanic_id kosong tetap boleh (server fallback)
document.querySelector('form').addEventListener('submit', function(e) {
    const serviceId = serviceSelect.value;
    if (!serviceId) {
        e.preventDefault();
        alert('Pilih jenis service terlebih dahulu!');
        return;
    }
});
</script>
@endsection