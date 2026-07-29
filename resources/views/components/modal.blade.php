@props(['name' => 'modal-default', 'title' => 'Modal Title'])

<flux:modal 
    name="{{ $name }}" 
    class="w-full h-dvh p-0 m-0 overflow-hidden bg-transparent border-none outline-none max-h-none max-w-none" 
    variant="bare"
    x-on:modal-show.document="window.lenis?.stop()"
    x-on:modal-close.document="window.lenis?.start(); setTimeout(() => { window.ScrollTrigger?.refresh(); window.dispatchEvent(new Event('resize')); }, 200)"
    x-on:close="window.lenis?.start(); setTimeout(() => { window.ScrollTrigger?.refresh(); window.dispatchEvent(new Event('resize')); }, 200)"
>
    <div class="h-full w-full overflow-y-auto overscroll-contain flex flex-col" data-lenis-prevent>
        <div class="flex min-h-full w-full items-start justify-center p-4 md:p-10">
            <div class="relative my-auto w-full max-w-4xl bg-pale-night-white dark:bg-pale-night-black rounded-3xl shadow-2xl p-6 md:p-10 space-y-8 flex flex-col">
                <div class="flex items-start justify-between">
                    <flux:heading
                        size="xl"
                        class="text-pale-night-black dark:text-pale-night-white font-bold"
                    >{{ $title }}</flux:heading>
    
                    <flux:modal.close>
                        <flux:button variant="ghost" icon="x-mark" class="md:hidden" />
                    </flux:modal.close>
                </div>
    
                <div class="text-pale-night-black/80 dark:text-pale-night-white/80 max-w-none space-y-4 text-base leading-relaxed md:text-lg flex-1">
                    {{ $slot }}
                </div>
    
                <div class="flex pb-8 md:pb-0">
                    <flux:spacer />
                    <flux:modal.close>
                        <flux:button variant="ghost">Close</flux:button>
                    </flux:modal.close>
                </div>
            </div>
        </div>
    </div>
</flux:modal>
