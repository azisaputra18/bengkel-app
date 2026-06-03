@extends('layouts.app')

@section('title', 'Tambah Service - BengkelPro')

@section('content')
<div class="max-w-2xl mx-auto">

    @if($errors->any())
    <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400 px-5 py-4 rounded-2xl font-bold text-sm">
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)
                <li class="text-xs">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="mb-8">
        <a href="/services" class="text-sm font-bold text-[#26D4B9] flex items-center gap-2 mb-4 hover:gap-3 transition-all w-fit">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar
        </a>
        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 dark:text-white tracking-tight">Tambah Service</h1>
        <p class="text-gray-500 dark:text-slate-400 mt-1 text-sm">Tentukan jenis layanan, spesialisasi, dan estimasi durasi.</p>
    </div>

    <div class="bg-white dark:bg-[#1e293b] rounded-[2rem] border border-gray-100 dark:border-slate-800 p-6 md:p-10 shadow-sm">
        <form action="/services" method="POST">
            @csrf
            <div class="space-y-6">

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest">
                        Nama Service <span class="text-red-400">*</span>
                    </label>
                    <input type="text" name="name" required
                        value="{{ old('name') }}"
                        placeholder="Contoh: Ketok Magic"
                        class="w-full bg-gray-50 dark:bg-slate-800 border-none rounded-2xl px-5 py-4 text-sm text-gray-800 dark:text-slate-200 placeholder-gray-300 dark:placeholder-slate-600 focus:ring-2 focus:ring-[#26D4B9] transition-all outline-none">
                    <p class="text-[11px] text-gray-400 dark:text-slate-500">Nama yang tampil saat pelanggan memilih layanan.</p>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest">
                        Kode Spesialisasi <span class="text-red-400">*</span>
                    </label>
                    <input type="text" name="specialization" required
                        value="{{ old('specialization') }}"
                        placeholder="Contoh: ketok_magic"
                        id="specialization_input"
                        class="w-full bg-gray-50 dark:bg-slate-800 border-none rounded-2xl px-5 py-4 text-sm text-gray-800 dark:text-slate-200 placeholder-gray-300 dark:placeholder-slate-600 focus:ring-2 focus:ring-[#26D4B9] transition-all outline-none font-mono">
                    <div class="flex items-start gap-2">
                        <i class="fa-solid fa-circle-info text-[#26D4B9] text-xs mt-0.5 flex-shrink-0"></i>
                        <p class="text-[11px] text-gray-400 dark:text-slate-500">
                            Harus sama persis dengan spesialisasi mekanik. Huruf kecil + underscore.
                            Contoh: <code class="bg-gray-100 dark:bg-slate-700 px-1 rounded">ketok_magic</code>
                        </p>
                    </div>
                    <button type="button" id="auto_gen_btn"
                        class="text-[10px] font-black text-[#26D4B9] uppercase tracking-widest flex items-center gap-1 hover:gap-2 transition-all">
                        <i class="fa-solid fa-wand-magic-sparkles"></i> Generate dari nama
                    </button>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest">
                        Estimasi Durasi <span class="text-red-400">*</span>
                    </label>
                    <div class="relative">
                        <input type="number" name="duration" required min="1"
                            value="{{ old('duration') }}"
                            placeholder="60"
                            class="w-full bg-gray-50 dark:bg-slate-800 border-none rounded-2xl px-5 py-4 pr-20 text-sm text-gray-800 dark:text-slate-200 placeholder-gray-300 dark:placeholder-slate-600 focus:ring-2 focus:ring-[#26D4B9] transition-all outline-none">
                        <span class="absolute right-5 top-1/2 -translate-y-1/2 font-black text-gray-400 dark:text-slate-500 text-sm">Menit</span>
                    </div>
                    <p class="text-[11px] text-gray-400 dark:text-slate-500">Untuk menghitung estimasi selesai di halaman pengerjaan.</p>
                </div>

                <button type="submit"
                    class="w-full bg-[#26D4B9] hover:bg-[#20bfa6] text-white font-black py-4 rounded-2xl shadow-lg shadow-[#26D4B9]/20 transition-all active:scale-95 uppercase tracking-widest flex items-center justify-center gap-2 text-sm mt-2">
                    <i class="fa-solid fa-save"></i> Simpan Data Service
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('auto_gen_btn').addEventListener('click', function() {
    const name = document.querySelector('input[name="name"]').value.trim();
    if (!name) { alert('Isi nama service dulu!'); return; }
    document.getElementById('specialization_input').value = name.toLowerCase().replace(/\s+/g, '_').replace(/[^a-z0-9_]/g, '');
});

document.querySelector('input[name="name"]').addEventListener('input', function() {
    document.getElementById('specialization_input').placeholder =
        this.value.toLowerCase().replace(/\s+/g, '_').replace(/[^a-z0-9_]/g, '') || 'Contoh: ketok_magic';
});
</script>
@endsection