@extends('layouts.app')

@section('title', 'Edit Mekanik - BengkelApp')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-10">
        <a href="/mechanics" class="text-[#26D4B9] font-bold text-sm flex items-center gap-2 mb-4 hover:gap-3 transition-all w-fit">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Mekanik
        </a>
        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 dark:text-white tracking-tight">Edit Data Mekanik</h1>
        <p class="text-gray-500 dark:text-slate-400 mt-2">Perbarui informasi profil dan spesialisasi mekanik.</p>
    </div>

    @if($errors->any())
    <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400 px-6 py-4 rounded-2xl font-bold text-sm">
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)
                <li class="text-xs">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 md:p-10 border border-gray-100 dark:border-slate-800 custom-shadow transition-colors duration-300">
        <form action="/mechanics/{{ $mechanic->id }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-8">
                <div class="space-y-6">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-8 h-8 bg-[#26D4B9]/10 text-[#26D4B9] rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-user-pen"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800 dark:text-slate-200">Perbarui Profil</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest ml-1">Nama Lengkap</label>
                            <input type="text" name="name"
                                value="{{ old('name', $mechanic->name) }}" required
                                class="w-full bg-gray-50 dark:bg-slate-800 border-none rounded-2xl px-5 py-4 text-sm text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-[#26D4B9] transition-all outline-none">
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest ml-1">Bidang Spesialisasi</label>
                            <div class="relative">
                                <select name="specialization" required
                                    class="w-full bg-gray-50 dark:bg-slate-800 border-none rounded-2xl px-5 py-4 text-sm text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-[#26D4B9] appearance-none cursor-pointer transition-all outline-none">
                                    <option value="" disabled>Pilih Keahlian</option>
                                    @foreach($services as $service)
                                        {{-- value pakai specialization supaya match sistem robin --}}
                                        <option value="{{ $service->specialization }}"
                                            {{ old('specialization', $mechanic->specialization) == $service->specialization ? 'selected' : '' }}>
                                            {{ $service->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-gray-400">
                                    <i class="fa-solid fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Info kode yang sudah ada --}}
                    <div class="bg-gray-50 dark:bg-slate-800 rounded-2xl px-5 py-4 flex items-center gap-3">
                        <div class="w-8 h-8 bg-[#26D4B9] rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-tag text-xs text-white"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest">Kode Mekanik</p>
                            <p class="text-sm font-black text-[#26D4B9]">{{ $mechanic->code ?? '-' }}</p>
                        </div>
                        <p class="text-[10px] text-gray-400 dark:text-slate-500 ml-auto">Kode tidak berubah saat edit</p>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="w-full bg-[#26D4B9] hover:bg-[#20bfa6] text-white py-5 rounded-[2rem] font-black uppercase tracking-widest shadow-xl shadow-[#26D4B9]/20 transition-all hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-3">
                        <i class="fa-solid fa-rotate text-lg"></i>
                        Update Data Mekanik
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection