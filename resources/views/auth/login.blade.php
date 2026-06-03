<x-guest-layout>
    <!-- Background Putih Abu-abu Sangat Muda (Sesuai Dashboard) -->
    <div class="fixed inset-0 flex items-center justify-center bg-[#F8FAFB] overflow-hidden">
        
        <!-- Ornamen Halus (Opsional, agar tidak terlalu polos) -->
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-0 right-0 w-[300px] h-[300px] bg-[#26D4B9]/5 blur-[100px] rounded-full"></div>
            <div class="absolute bottom-0 left-0 w-[300px] h-[300px] bg-[#26D4B9]/5 blur-[100px] rounded-full"></div>
        </div>

        <main class="relative w-full max-w-[420px] z-10 px-6">
            <!-- Kartu Login Putih Bersih (Sesuai Dashboard) -->
            <div class="rounded-[2.5rem] bg-white p-10 shadow-[0_10px_40px_rgba(0,0,0,0.03)] border border-gray-100">
                
                <!-- Logo Area -->
                <div class="flex flex-col items-center mb-10">
                    <div class="h-14 w-14 rounded-full bg-[#26D4B9] flex items-center justify-center text-white text-2xl mb-4 shadow-lg shadow-[#26D4B9]/20 font-bold">
                          <i class="fa-solid fa-wrench"></i>
                    </div>
                    <h1 class="text-2xl font-black tracking-tight text-[#1A1D1F] uppercase">BENGKEL<span class="text-[#26D4B9]">PRO</span></h1>
                    <p class="text-gray-400 mt-1 font-medium text-sm text-center italic">Masuk ke sistem manajemen antrean</p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <!-- Email Address -->
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider ml-1">Email Address</label>
                        <input
                            type="email"
                            name="email"
                            placeholder="admin@bengkel.com"
                            value="{{ old('email') }}"
                            required
                            class="w-full bg-[#F4F7F9] border-transparent rounded-2xl px-6 py-4 text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#26D4B9]/20 focus:border-[#26D4B9] transition-all font-medium"
                        />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="space-y-2">
                        <div class="flex justify-between items-center px-1">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider">Password</label>
                            <a href="{{ route('password.request') }}" class="text-xs font-bold text-[#26D4B9] hover:underline">Lupa?</a>
                        </div>
                        <input
                            type="password"
                            name="password"
                            placeholder="••••••••"
                            required
                            class="w-full bg-[#F4F7F9] border-transparent rounded-2xl px-6 py-4 text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#26D4B9]/20 focus:border-[#26D4B9] transition-all font-medium"
                        />
                    </div>

                    <div class="pt-4">
                        <button
                            type="submit"
                            class="w-full rounded-2xl bg-[#26D4B9] py-4 text-white font-bold text-lg transition-all hover:bg-[#20bfa6] hover:shadow-xl hover:shadow-[#26D4B9]/20 active:scale-[0.98]"
                        >
                            Sign In
                        </button>
                    </div>

                    <!-- Footer Link -->
                    <div class="text-center mt-6">
                        <p class="text-sm text-gray-400 font-medium">
                            Belum punya akun? 
                            <a href="{{ route('register') }}" class="text-[#26D4B9] font-bold hover:underline">Hubungi Admin</a>
                        </p>
                    </div>
                </form>
            </div>

            <!-- Copyright (Sesuai Footer Dashboard) -->
            <div class="text-center mt-10">
                <p class="text-gray-400 text-[10px] font-bold uppercase tracking-[0.2em]">
                    &copy; 2026 AZISAPUTRA &bull; VERSI 1.0.0
                </p>
            </div>
        </main>
    </div>
</x-guest-layout>