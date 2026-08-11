@props([
    'name' => 'modal-default', 
    'title' => 'Modal Title',
    'titleClass' => null,
    'tags' => [],
    'show' => false,
])

<flux:modal 
    name="{{ $name }}" 
    :x-init="$show ? '$nextTick(() => $flux.modal(\'' . $name . '\').show())' : null"
    class="w-full h-dvh p-0 m-0 overflow-hidden bg-transparent border-none outline-none max-h-none max-w-none" 
    variant="bare"
    x-on:modal-show.document="window.lenis?.stop()"
    x-on:modal-close.document="window.lenis?.start(); setTimeout(() => { window.ScrollTrigger?.refresh(); window.dispatchEvent(new Event('resize')); }, 200)"
    x-on:close="window.lenis?.start(); setTimeout(() => { window.ScrollTrigger?.refresh(); window.dispatchEvent(new Event('resize')); }, 200)"
>
    <div class="h-full w-full overflow-y-auto overscroll-contain flex flex-col" data-lenis-prevent>
        <div class="flex min-h-full w-full items-start justify-center p-4 md:p-10">
            <div class="relative my-auto w-full max-w-4xl bg-pale-night-white dark:bg-pale-night-black rounded-3xl shadow-2xl p-6 md:p-10 space-y-8 flex flex-col overflow-hidden">
                @if (isset($animation))
                    <div class="absolute inset-0 z-0 pointer-events-none opacity-40 dark:opacity-30">
                        {{ $animation }}
                    </div>
                @endif

                <div class="relative z-10 flex flex-col gap-4">
                    <div class="flex items-start justify-between gap-x-8">
                        <flux:heading
                            size="xl"
                            class="font-bold {{ $titleClass ?? 'text-pale-night-black dark:text-pale-night-white' }}"
                        >{{ $title }}</flux:heading>

                        <flux:modal.close>
                            <x-button class="size-10 p-0 bg-pale-night-black/5 dark:bg-white/5 text-pale-night-black dark:text-pale-night-white ring-pale-night-black/10 dark:ring-white/20 hover:bg-pale-night-black/10 dark:hover:bg-white/10 shrink-0" aria-label="Close">
                                <flux:icon.x-mark variant="outline" />
                            </x-button>
                        </flux:modal.close>
                    </div>

                    @if (! empty($tags))
                        <div class="flex flex-wrap gap-2">
                            @foreach ($tags as $tag)
                                <x-tag>{{ $tag }}</x-tag>
                            @endforeach
                        </div>
                    @endif
                </div>
    
                <div class="relative z-10 text-pale-night-black/80 dark:text-pale-night-white/80 max-w-none space-y-4 text-base leading-relaxed md:text-lg flex-1">
                    {{ $slot }}
                </div>
    
                <div class="relative z-10 flex pb-8 md:pb-0">
                    <flux:modal.close>
                        <x-button class="bg-pale-night-black/5 dark:bg-white/5 text-pale-night-black dark:text-pale-night-white ring-pale-night-black/10 dark:ring-white/20 hover:bg-pale-night-black/10 dark:hover:bg-white/10">Close</x-button>
                    </flux:modal.close>
                </div>
            </div>
        </div>
    </div>
</flux:modal>
