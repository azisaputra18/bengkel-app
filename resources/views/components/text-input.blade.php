@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' => 'w-full bg-gray-50/5 dark:bg-slate-800/50 border-gray-200 dark:border-slate-700/50 text-gray-900 dark:text-white focus:border-[#26D4B9] dark:focus:border-[#26D4B9] focus:ring focus:ring-[#26D4B9] focus:ring-opacity-20 rounded-xl shadow-sm transition-all duration-200 py-3 px-4 text-sm font-medium'
]) !!}>