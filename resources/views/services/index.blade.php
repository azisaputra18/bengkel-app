@extends('layouts.app')

@section('title', 'Data Service - BengkelPro')

@section('content')

{{-- Modal Konfirmasi Hapus --}}
<div id="delete-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" id="modal-overlay"></div>
    <div class="relative bg-white dark:bg-[#1e293b] rounded-[2rem] p-8 w-full max-w-sm shadow-2xl border border-gray-100 dark:border-slate-700 z-10">
        <div class="w-14 h-14 bg-red-50 dark:bg-red-900/20 rounded-2xl flex items-center justify-center mx-auto mb-5">
            <i class="fa-solid fa-trash-can text-red-500 text-xl"></i>
        </div>
        <h3 class="text-lg font-black text-gray-800 dark:text-white text-center mb-2">Hapus Service?</h3>
        <p class="text-sm text-gray-500 dark:text-slate-400 text-center mb-6">
            Service <strong id="modal-service-name" class="text-gray-800 dark:text-white"></strong> akan dihapus permanen dan tidak bisa dikembalikan.
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
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
    <div>
        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 dark:text-white tracking-tight">Data Service</h1>
        <p class="text-gray-500 dark:text-slate-400 mt-1 text-sm">Kelola daftar layanan dan spesialisasi bengkel.</p>
    </div>
    <a href="/services/create"
        class="flex items-center gap-2 bg-[#26D4B9] hover:bg-[#20bfa6] text-white px-5 py-3 rounded-2xl font-bold shadow-lg shadow-[#26D4B9]/20 transition-all active:scale-95 text-sm whitespace-nowrap">
        <i class="fa-solid fa-plus"></i> Tambah Service
    </a>
</div>

{{-- Flash --}}
@if(session('success'))
<div class="mb-6 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-900/30 text-emerald-700 dark:text-emerald-400 px-5 py-4 rounded-2xl font-bold text-sm flex items-center gap-3">
    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
</div>
@endif

<!-- Table Card -->
<div class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-gray-100 dark:border-slate-800 custom-shadow overflow-hidden transition-colors duration-300">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50 dark:bg-slate-800/50 border-b border-gray-50 dark:border-slate-800">
                    <th class="px-6 py-5 text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest">Nama Service</th>
                    <th class="px-6 py-5 text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest hidden sm:table-cell">Spesialisasi</th>
                    <th class="px-6 py-5 text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest hidden md:table-cell">Durasi</th>
                    <th class="px-6 py-5 text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 dark:divide-slate-800">
                @forelse($services as $s)
                <tr class="group hover:bg-gray-50/30 dark:hover:bg-slate-800/30 transition-colors">
                    <td class="px-6 py-5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gray-100 dark:bg-slate-800 rounded-xl flex items-center justify-center text-gray-400 group-hover:text-[#26D4B9] transition-colors flex-shrink-0">
                                <i class="fa-solid fa-gears text-sm"></i>
                            </div>
                            <div>
                                <p class="font-black text-gray-800 dark:text-slate-200 text-sm">{{ $s->name }}</p>
                                {{-- Mobile: tampil spesialisasi di sini --}}
                                <p class="text-[10px] text-gray-400 dark:text-slate-500 font-mono mt-0.5 sm:hidden">{{ $s->specialization }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-5 hidden sm:table-cell">
                        <code class="bg-gray-100 dark:bg-slate-800 text-gray-600 dark:text-slate-400 px-3 py-1 rounded-lg text-xs font-bold">
                            {{ $s->specialization }}
                        </code>
                    </td>
                    <td class="px-6 py-5 hidden md:table-cell">
                        <div class="flex items-center gap-2">
                            <i class="fa-regular fa-clock text-xs text-gray-400"></i>
                            <span class="text-sm font-bold text-gray-600 dark:text-slate-400">
                                @if($s->duration >= 60)
                                    {{ floor($s->duration / 60) }} Jam
                                    @if($s->duration % 60 > 0)
                                        {{ $s->duration % 60 }} Menit
                                    @endif
                                @else
                                    {{ $s->duration }} Menit
                                @endif
                            </span>
                        </div>
                    </td>
                    <td class="px-6 py-5">
                        <div class="flex justify-end gap-2">
                            <a href="/services/{{ $s->id }}/edit"
                                class="w-9 h-9 flex items-center justify-center rounded-xl bg-amber-50 dark:bg-amber-900/20 text-amber-500 hover:bg-amber-500 hover:text-white transition-all">
                                <i class="fa-solid fa-pen-to-square text-xs"></i>
                            </a>
                            <button type="button"
                                onclick="openDeleteModal({{ $s->id }}, '{{ addslashes($s->name) }}')"
                                class="w-9 h-9 flex items-center justify-center rounded-xl bg-red-50 dark:bg-red-900/20 text-red-500 hover:bg-red-500 hover:text-white transition-all">
                                <i class="fa-solid fa-trash-can text-xs"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-20 text-center">
                        <div class="flex flex-col items-center gap-4">
                            <div class="w-16 h-16 bg-gray-100 dark:bg-slate-800 rounded-3xl flex items-center justify-center">
                                <i class="fa-solid fa-gears text-2xl text-gray-300 dark:text-slate-600"></i>
                            </div>
                            <p class="text-gray-400 dark:text-slate-500 font-medium">Belum ada data service</p>
                            <a href="/services/create"
                                class="bg-[#26D4B9] text-white px-6 py-3 rounded-2xl font-bold text-sm">
                                + Tambah Service
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
function openDeleteModal(id, name) {
    document.getElementById('modal-service-name').textContent = name;
    document.getElementById('modal-form').action = `/services/${id}`;
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