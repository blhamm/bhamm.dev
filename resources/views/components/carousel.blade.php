@props(['title' => null])
<div
    x-data="{
        init() {
            Draggable.create(this.$refs.container, {
                type: 'scrollLeft',
                edgeResistance: 0.85,
                dragClickables: true,
                allowNativeTouchScrolling: true,
                onDragStart: () => {
                    this.$refs.container.style.scrollSnapType = 'none';
                },
                onDragEnd: () => {
                    this.$refs.container.style.scrollSnapType = 'x mandatory';
                },
            });

            // Animation for items
            const items = this.$refs.container.querySelectorAll('.snap-start');
            gsap.from(items, {
                scrollTrigger: {
                    trigger: this.$refs.container,
                    start: 'top 85%',
                    toggleActions: 'play none none reverse',
                },
                y: 50,
                autoAlpha: 0,
                duration: 1.2,
                stagger: 0.15,
                ease: 'expo.out',
                clearProps: 'all',
            });
        },
        prev() {
            const container = this.$refs.container;
            const items = Array.from(container.querySelectorAll('.shrink-0'));
            if (items.length === 0) return;
            const currentScroll = container.scrollLeft;
            const targetItem = [...items].reverse().find((item) => item.offsetLeft < currentScroll - 5) || items[0];
            gsap.to(container, {
                scrollTo: { x: targetItem.offsetLeft },
                duration: 0.6,
                ease: 'power2.out',
                onStart: () => {
                    container.style.scrollSnapType = 'none';
                },
                onComplete: () => {
                    container.style.scrollSnapType = 'x mandatory';
                },
            });
        },
        next() {
            const container = this.$refs.container;
            const items = Array.from(container.querySelectorAll('.shrink-0'));
            if (items.length === 0) return;
            const currentScroll = container.scrollLeft;
            const targetItem = items.find((item) => item.offsetLeft > currentScroll + 5);
            if (! targetItem) return;
            gsap.to(container, {
                scrollTo: { x: targetItem.offsetLeft },
                duration: 0.6,
                ease: 'power2.out',
                onStart: () => {
                    container.style.scrollSnapType = 'none';
                },
                onComplete: () => {
                    container.style.scrollSnapType = 'x mandatory';
                },
            });
        },
    }"
    {{ $attributes->merge(['class' => 'relative w-full max-w-full group overflow-x-hidden']) }}
>
    <div class="mb-4 px-2">
        @if (isset($header))
            {{ $header }}
        @elseif (isset($title))
            <h3 class="dark:text-pale-night-white text-xl font-bold text-gray-700">{{ $title }}</h3>
        @endif
    </div>

    <div x-ref="container" class="no-scrollbar relative w-full touch-pan-y snap-x snap-mandatory overflow-x-auto pb-4">
        <div class="flex w-max min-w-full flex-row flex-nowrap items-center gap-6">{{ $slot }}</div>
    </div>

    <div class="mt-4 flex justify-end gap-2 px-2">
        <flux:button
            icon="chevron-left"
            variant="ghost"
            x-on:click="prev()"
            aria-label="Previous"
            class="bg-pale-night-black/10 dark:bg-pale-night-white/20 text-pale-night-black/70 dark:text-pale-night-white hover:bg-pale-night-black/20 dark:hover:bg-pale-night-white/30 rounded-full transition-colors"
        />
        <flux:button
            icon="chevron-right"
            variant="ghost"
            x-on:click="next()"
            aria-label="Next"
            class="bg-pale-night-black/10 dark:bg-pale-night-white/20 text-pale-night-black/70 dark:text-pale-night-white hover:bg-pale-night-black/20 dark:hover:bg-pale-night-white/30 rounded-full transition-colors"
        />
    </div>
</div>
