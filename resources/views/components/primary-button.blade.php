<button {{ $attributes->merge([
    'type' => 'submit', 
    'class' => 'inline-flex items-center justify-center px-6 py-3 bg-[#26D4B9] border border-transparent rounded-xl font-black text-[10px] text-white uppercase tracking-[0.2em] hover:bg-[#20bfa6] hover:shadow-lg hover:shadow-[#26D4B9]/20 active:scale-95 focus:outline-none focus:ring-2 focus:ring-[#26D4B9] focus:ring-offset-2 dark:focus:ring-offset-slate-900 transition all ease-in-out duration-150'
]) }}>
    {{ $slot }}
</button>