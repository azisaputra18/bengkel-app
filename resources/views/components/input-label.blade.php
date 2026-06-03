@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-[10px] font-black text-gray-400 dark:text-slate-400 uppercase tracking-widest mb-2']) }}>
    {{ $value ?? $slot }}
</label>