@extends('layouts.app')

@section('title', 'Profil Saya - BengkelPro')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 pb-12">
    
    <div class="relative mb-12">
        <div class="h-32 w-full bg-gradient-to-r from-[#26D4B9] to-blue-500 rounded-[2.5rem]"></div>
        <div class="absolute -bottom-10 left-10 flex items-end gap-6">
            <div class="w-24 h-24 rounded-[2rem] bg-white dark:bg-slate-900 p-2 shadow-xl">
                <div class="w-full h-full rounded-[1.5rem] bg-[#26D4B9] flex items-center justify-center text-white text-3xl font-black shadow-inner">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            </div>
            <div class="mb-2">
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">{{ Auth::user()->name }}</h1>
                <p class="text-emerald-500 font-bold text-sm uppercase tracking-widest">{{ Auth::user()->role ?? 'Staff Bengkel' }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="space-y-6">
            <div class="bg-white dark:bg-[#1e293b] p-6 rounded-[2rem] border border-gray-100 dark:border-slate-800 shadow-sm">
                <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Informasi Akun</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-[10px] text-gray-400 uppercase font-bold">Email Resmi</p>
                        <p class="text-sm font-bold text-gray-700 dark:text-slate-300">{{ Auth::user()->email }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 uppercase font-bold">Bergabung Sejak</p>
                        <p class="text-sm font-bold text-gray-700 dark:text-slate-300">{{ Auth::user()->created_at->format('d M Y') }}</p>
                    </div>
                </div>

                <hr class="my-6 border-gray-50 dark:border-slate-800">

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full bg-red-50 dark:bg-red-900/10 text-red-500 py-3 rounded-xl font-black text-xs uppercase tracking-widest hover:bg-red-500 hover:text-white transition-all">
                        Keluar Sistem
                    </button>
                </form>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-8">
            
            {{-- Update Profile Information --}}
            <div class="bg-white dark:bg-[#1e293b] p-8 rounded-[2.5rem] border border-gray-100 dark:border-slate-800 shadow-sm">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Update Password --}}
            <div class="bg-white dark:bg-[#1e293b] p-8 rounded-[2.5rem] border border-gray-100 dark:border-slate-800 shadow-sm">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Delete User (Optional) --}}
            <div class="bg-red-50/50 dark:bg-red-900/5 p-8 rounded-[2.5rem] border border-red-100 dark:border-red-900/20 shadow-sm">
                <div class="max-w-xl text-red-700 dark:text-red-400">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>

    </div>
</div>
@endsection