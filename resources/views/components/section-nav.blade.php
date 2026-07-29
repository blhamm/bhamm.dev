@props(['mode' => 'pill'])

<nav {{
    $attributes->class([
        'flex items-center gap-2 p-1 rounded-lg bg-zinc-100 dark:bg-pale-night-black' => $mode === 'pill',
        'flex items-center gap-4 border-b border-zinc-200 dark:border-zinc-800' => $mode === 'tabs',
        'flex flex-col gap-2' => $mode === 'stacked',
        'sticky top-20 z-40' => $mode === 'sticky',
    ])
}}>
    {{ $slot }}
</nav>
