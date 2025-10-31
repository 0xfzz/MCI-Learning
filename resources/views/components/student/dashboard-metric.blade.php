@props(['label', 'value', 'icon' => 'fa-solid fa-chart-column', 'color' => 'bg-[#025f5a]'])

<div class="relative overflow-hidden rounded-3xl border border-gray-200 dark:border-gray-800 bg-white/95 dark:bg-gray-900/95 p-6 shadow-[0_18px_40px_rgba(2,95,90,0.08)]">
    <div class="absolute -top-12 -right-10 w-28 h-28 rounded-full opacity-10 {{ $color }}"></div>
    <div class="relative z-10">
        <div class="flex items-center justify-between mb-4">
            <span class="text-xs uppercase tracking-wide text-gray-400 dark:text-gray-500 font-semibold">{{ $label }}</span>
            <span class="text-lg w-9 h-9 inline-flex items-center justify-center rounded-2xl {{ $color }} text-white"><i class="{{ $icon }}"></i></span>
        </div>
        <p class="text-3xl font-black text-gray-900 dark:text-gray-100">{{ $value }}</p>
    </div>
</div>
