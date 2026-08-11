@props(['title' => null])
<div
    x-data="{
        init() {
            // Only use Draggable on desktop for mouse users.
            // On touch devices, native scroll + snap is much smoother and handles inertia correctly.
            if (!window.matchMedia('(pointer: coarse)').matches) {
                Draggable.create(this.$refs.container, {
                    type: 'scrollLeft',
                    edgeResistance: 0.85,
                    dragClickables: true,
                    onDragStart: () => {
                        this.$refs.container.style.scrollSnapType = 'none';
                    },
                    onDragEnd: () => {
                        this.$refs.container.style.scrollSnapType = 'x mandatory';
                    },
                });
            }

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
            const flex = container.querySelector('.flex');
            const containerPadding = parseFloat(window.getComputedStyle(flex).paddingLeft);
            const items = Array.from(flex.querySelectorAll('.shrink-0'));
            if (items.length === 0) return;
            
            const currentScroll = container.scrollLeft;
            const targetItem = [...items].reverse().find((item) => (item.offsetLeft - containerPadding) < currentScroll - 20);
            
            gsap.killTweensOf(container);

            if (! targetItem) {
                // Rewind to end
                const lastItem = items[items.length - 1];
                gsap.to(container, {
                    scrollTo: { x: Math.max(0, lastItem.offsetLeft - containerPadding) },
                    duration: 1,
                    roundProps: 'scrollLeft',
                    ease: 'power3.inOut',
                    onStart: () => {
                        container.style.scrollBehavior = 'auto';
                        container.style.scrollSnapType = 'none';
                    },
                    onComplete: () => {
                        container.style.scrollSnapType = 'x mandatory';
                        container.style.scrollBehavior = '';
                    },
                });
                return;
            }

            gsap.to(container, {
                scrollTo: { x: Math.max(0, targetItem.offsetLeft - containerPadding) },
                duration: 0.5,
                roundProps: 'scrollLeft',
                ease: 'power2.out',
                onStart: () => {
                    container.style.scrollBehavior = 'auto';
                    container.style.scrollSnapType = 'none';
                },
                onComplete: () => {
                    container.style.scrollSnapType = 'x mandatory';
                    container.style.scrollBehavior = '';
                },
            });
        },
        next() {
            const container = this.$refs.container;
            const flex = container.querySelector('.flex');
            const containerPadding = parseFloat(window.getComputedStyle(flex).paddingLeft);
            const items = Array.from(flex.querySelectorAll('.shrink-0'));
            if (items.length === 0) return;
        
            const currentScroll = container.scrollLeft;
            const targetItem = items.find((item) => (item.offsetLeft - containerPadding) > currentScroll + 20);
            
            gsap.killTweensOf(container);

            if (! targetItem) {
                // Rewind to beginning
                gsap.to(container, {
                    scrollTo: { x: 0 },
                    duration: 1,
                    roundProps: 'scrollLeft',
                    ease: 'power3.inOut',
                    onStart: () => {
                        container.style.scrollBehavior = 'auto';
                        container.style.scrollSnapType = 'none';
                    },
                    onComplete: () => {
                        container.style.scrollSnapType = 'x mandatory';
                        container.style.scrollBehavior = '';
                    },
                });
                return;
            }

            gsap.to(container, {
                scrollTo: { x: Math.max(0, targetItem.offsetLeft - containerPadding) },
                duration: 0.5,
                roundProps: 'scrollLeft',
                ease: 'power2.out',
                onStart: () => {
                    container.style.scrollBehavior = 'auto';
                    container.style.scrollSnapType = 'none';
                },
                onComplete: () => {
                    container.style.scrollSnapType = 'x mandatory';
                    container.style.scrollBehavior = '';
                },
            });
        },
    }"
    {{ $attributes->merge(['class' => 'relative w-full group overflow-x-hidden [--padding:1rem] sm:[--padding:1.5rem] lg:[--padding:2rem]']) }}
>
    <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8 mb-8">
        @if (isset($header))
            {{ $header }}
        @elseif (isset($title))
            <h3 class="text-pale-night-black dark:text-pale-night-white text-xl font-bold">{{ $title }}</h3>
        @endif
    </div>

    <div 
        x-ref="container" 
        class="no-scrollbar relative w-full snap-x snap-mandatory overflow-x-auto pb-8 overscroll-x-contain"
        data-lenis-prevent
        style="scroll-padding-left: max(var(--padding), calc((100vw - 80rem) / 2 + var(--padding))); scroll-padding-right: max(var(--padding), calc((100vw - 80rem) / 2 + var(--padding))); scroll-behavior: auto;"
    >
        <div class="flex w-max min-w-full flex-row flex-nowrap items-stretch gap-8 md:gap-12" style="padding-left: max(var(--padding), calc((100vw - 80rem) / 2 + var(--padding))); padding-right: max(var(--padding), calc((100vw - 80rem) / 2 + var(--padding)));">
            {{ $slot }}
        </div>
    </div>

    <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8 mt-4 flex justify-end gap-3">
        <x-button
            x-on:click="prev()"
            aria-label="Previous"
            class="glass-pane size-10 p-0 text-pale-night-black dark:text-pale-night-white hover:scale-110 active:scale-95 ring-pale-night-black/10 dark:ring-white/20"
        >
            <flux:icon.chevron-left variant="outline" />
        </x-button>
        <x-button
            x-on:click="next()"
            aria-label="Next"
            class="glass-pane size-10 p-0 text-pale-night-black dark:text-pale-night-white hover:scale-110 active:scale-95 ring-pale-night-black/10 dark:ring-white/20"
        >
            <flux:icon.chevron-right variant="outline" />
        </x-button>
    </div>
</div>
