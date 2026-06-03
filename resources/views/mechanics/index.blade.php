@extends('layouts.app')

@section('title', 'Data Mekanik - BengkelApp')

@section('content')
<div class="max-w-6xl mx-auto">

    {{-- Modal Konfirmasi Hapus --}}
    <div id="delete-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" id="modal-overlay"></div>
        <div class="relative bg-white dark:bg-[#1e293b] rounded-[2rem] p-8 w-full max-w-sm shadow-2xl border border-gray-100 dark:border-slate-700 z-10">
            <div class="w-14 h-14 bg-red-50 dark:bg-red-900/20 rounded-2xl flex items-center justify-center mx-auto mb-5">
                <i class="fa-solid fa-user-slash text-red-500 text-xl"></i>
            </div>
            <h3 class="text-lg font-black text-gray-800 dark:text-white text-center mb-2">Hapus Mekanik?</h3>
            <p class="text-sm text-gray-500 dark:text-slate-400 text-center mb-6">
                Mekanik <strong id="modal-mechanic-name" class="text-gray-800 dark:text-white"></strong> akan dihapus permanen.
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
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-10">
        <div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 dark:text-white tracking-tight">Data Mekanik</h1>
            <p class="text-gray-500 dark:text-slate-400 mt-2">Kelola tim mekanik dan spesialisasi mereka.</p>
        </div>
        <a href="/mechanics/create"
            class="bg-[#26D4B9] hover:bg-[#20bfa6] text-white px-6 py-4 rounded-2xl font-bold flex items-center gap-2 shadow-xl shadow-[#26D4B9]/20 transition-all hover:-translate-y-1 active:scale-95 text-sm uppercase tracking-wider whitespace-nowrap">
            <i class="fa-solid fa-plus-circle"></i> Tambah Mekanik
        </a>
    </div>

    @if(session('success'))
    <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-500 p-4 rounded-2xl mb-8 flex items-center gap-3">
        <i class="fa-solid fa-circle-check text-xl"></i>
        <span class="font-bold text-sm">{{ session('success') }}</span>
    </div>
    @endif

    <!-- Table Card -->
    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-gray-100 dark:border-slate-800 custom-shadow overflow-hidden transition-colors duration-300">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50 dark:bg-slate-800/50 border-b border-gray-50 dark:border-slate-800">
                        <th class="px-6 py-6 text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-[0.2em]">Mekanik</th>
                        <th class="px-6 py-6 text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-[0.2em] hidden sm:table-cell">Kode</th>
                        <th class="px-6 py-6 text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-[0.2em] hidden md:table-cell">Bidang Keahlian</th>
                        <th class="px-6 py-6 text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-[0.2em] text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-slate-800">
                    @forelse($mechanics as $m)
                    <tr class="group hover:bg-gray-50/50 dark:hover:bg-slate-800/50 transition-colors">

                        {{-- Mekanik --}}
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-11 h-11 bg-gray-100 dark:bg-slate-800 rounded-2xl flex items-center justify-center shadow-inner group-hover:bg-[#26D4B9]/20 group-hover:text-[#26D4B9] transition-all flex-shrink-0">
                                    <i class="fa-solid fa-user-gear"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-gray-800 dark:text-slate-200 text-sm">{{ $m->name }}</p>
                                    <p class="text-[10px] text-gray-400 font-medium uppercase tracking-widest">
                                        MKN-{{ str_pad($m->id, 3, '0', STR_PAD_LEFT) }}
                                    </p>
                                    {{-- Mobile: tampil kode & spesialisasi di sini --}}
                                    <div class="flex items-center gap-2 mt-1 sm:hidden">
                                        <span class="text-[10px] font-black text-[#26D4B9] bg-[#26D4B9]/10 px-2 py-0.5 rounded-lg">
                                            {{ $m->code ?? '-' }}
                                        </span>
                                        <span class="text-[10px] text-gray-400 font-bold uppercase">
                                            {{ $m->specialization }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </td>

                        {{-- Kode — hidden di mobile --}}
                        <td class="px-6 py-5 hidden sm:table-cell">
                            <span class="w-10 h-10 bg-[#26D4B9]/10 text-[#26D4B9] rounded-xl flex items-center justify-center font-black text-sm border border-[#26D4B9]/20">
                                {{ $m->code ?? '-' }}
                            </span>
                        </td>

                        {{-- Spesialisasi — hidden di tablet ke bawah --}}
                        <td class="px-6 py-5 hidden md:table-cell">
                            <span class="bg-[#26D4B9]/10 text-[#26D4B9] px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-wider border border-[#26D4B9]/20">
                                {{ $m->specialization }}
                            </span>
                        </td>

                        {{-- Aksi --}}
                        <td class="px-6 py-5">
                            <div class="flex items-center justify-center gap-2">
                                <a href="/mechanics/{{ $m->id }}/edit"
                                    class="w-9 h-9 bg-amber-500/10 text-amber-500 rounded-xl flex items-center justify-center hover:bg-amber-500 hover:text-white transition-all">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                </a>
                                <button type="button"
                                    onclick="openDeleteModal({{ $m->id }}, '{{ addslashes($m->name) }}')"
                                    class="w-9 h-9 bg-rose-500/10 text-rose-500 rounded-xl flex items-center justify-center hover:bg-rose-500 hover:text-white transition-all">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center gap-4">
                                <div class="w-20 h-20 bg-gray-50 dark:bg-slate-800 rounded-[2rem] flex items-center justify-center text-gray-300 dark:text-slate-700 text-3xl">
                                    <i class="fa-solid fa-users-slash"></i>
                                </div>
                                <div>
                                    <p class="text-gray-800 dark:text-slate-200 font-bold">Belum ada mekanik</p>
                                    <p class="text-gray-400 dark:text-slate-500 text-sm">Silakan tambahkan mekanik pertama Anda.</p>
                                </div>
                                <a href="/mechanics/create" class="text-[#26D4B9] font-bold text-sm hover:underline italic">
                                    + Tambah Data Sekarang
                                </a>
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
function openDeleteModal(id, name) {
    document.getElementById('modal-mechanic-name').textContent = name;
    document.getElementById('modal-form').action = `/mechanics/${id}`;
    const modal = document.getElementById('delete-modal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeDeleteModal() {
    const modal = document.getElementById('delete-modal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

document.getElementById('modal-cancel').addEventListener('click', closeDeleteModal);
document.getElementById('modal-overlay').addEventListener('click', closeDeleteModal);
</script>
@endsection