<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Login - BENGKELPRO</title>
        

        <link rel="icon" type="image/svg+xml" href="{{ asset('logo.svg') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased bg-[#F0F5FA]">
        <div class="min-h-screen flex flex-col sm:justify-center items-center py-6 px-4">
            {{-- Slot ini akan berisi konten dari login.blade.php --}}
            {{ $slot }}
            
            {{-- Footer Opsional --}}
            <div class="mt-8 text-center">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">
                    &copy; {{ date('Y') }} BENGKELPRO - Ketok Magic Precision
                </p>
            </div>
        </div>
    </body>
</html>