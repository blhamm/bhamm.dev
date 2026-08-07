@props(['href' => '#', 'active' => false])

<a
    href="{{ $href }}"
    {{
        $attributes->class([
            'px-5 py-2 rounded-full text-sm font-medium transition-all duration-200',
            'bg-pale-night-white text-pale-night-black shadow-sm dark:bg-pale-night-darker dark:text-white' => $active,
            'text-zinc-600 hover:text-zinc-900 hover:bg-pale-night-black/5 dark:text-zinc-400 dark:hover:text-white dark:hover:bg-pale-night-white/5' => ! $active,
        ])
    }}
>
    {{ $slot }}
</a>
