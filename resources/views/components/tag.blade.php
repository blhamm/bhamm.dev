@props([])
<span {{ $attributes->merge(['class' => "inline-flex items-center rounded-full bg-pale-night-black/5 dark:bg-pale-night-white/10 px-3 py-1 text-xs font-semibold text-pale-night-black dark:text-pale-night-white ring-1 ring-inset ring-pale-night-black/10 dark:ring-pale-night-white/20"]) }}>
    {{ $slot }}
</span>
