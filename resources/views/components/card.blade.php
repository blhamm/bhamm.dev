@props([])
<div {{ $attributes->class(['relative overflow-hidden rounded-3xl border border-zinc-200 dark:border-zinc-800 bg-pale-night-black/5 shadow-sm transition-all hover:shadow-md flex flex-col ring-1 ring-inset ring-pale-night-black/10']) }}>
    @isset($background)
        <div class="absolute inset-0 z-0">
            {{ $background }}
            <div class="absolute inset-0"></div>
        </div>
    @endisset

    @isset($image)
        <div class="z-10 w-full shrink-0">{{ $image }}</div>
    @endisset

    <div class="p-6 flex-1 flex flex-col z-10 @isset($background) text-white @endisset">
        @isset($tags)
            <div class="mb-3 flex flex-wrap gap-2">{{ $tags }}</div>
        @endisset

        @isset($title)
            <div class="mb-2">{{ $title }}</div>
        @endisset

        @isset($description)
            <div class="text-sm @isset($background) text-zinc-200 @else text-zinc-600 @endisset mb-4">
                {{ $description }}
            </div>
        @endisset

        <div class="mt-auto">{{ $slot }}</div>
    </div>
</div>
