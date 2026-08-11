@props([])
<div {{ $attributes->class(['glass-pane relative overflow-hidden rounded-3xl shadow-sm transition-all hover:shadow-md flex flex-col']) }}>
    @isset($background)
        <div class="absolute inset-0 z-0">
            {{ $background }}
            <div class="absolute inset-0"></div>
        </div>
    @endisset

    @isset($image)
        <div class="z-10 w-full shrink-0">{{ $image }}</div>
    @endisset

    <div class="px-4 py-6 sm:p-6 flex-1 flex flex-col z-10">
        @isset($tags)
            <div class="mb-3 flex flex-wrap gap-2">{{ $tags }}</div>
        @endisset

        @isset($title)
            <div class="mb-2">{{ $title }}</div>
        @endisset

        @isset($description)
            <div class="text-base sm:text-lg text-pale-night-black/70 dark:text-pale-night-white/70 mb-6 leading-relaxed">
                {{ $description }}
            </div>
        @endisset

        <div class="mt-auto">{{ $slot }}</div>
    </div>
</div>
