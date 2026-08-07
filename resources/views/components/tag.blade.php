@props([])
<span {{ $attributes->merge(['class' => "inline-flex items-center rounded-md bg-pale-night-black/5 dark:bg-pale-night-white/10 px-2 py-1 text-xs font-medium text-pale-night-black/60 dark:text-pale-night-white/60 ring-1 ring-inset ring-pale-night-black/10 dark:ring-pale-night-white/20"]) }}>
    {{ $slot }}
</span>
