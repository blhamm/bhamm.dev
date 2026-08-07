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
                        container.style.scrollSnapType = 'none';
                    },
                    onComplete: () => {
                        container.style.scrollSnapType = 'x mandatory';
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
                    container.style.scrollSnapType = 'none';
                },
                onComplete: () => {
                    container.style.scrollSnapType = 'x mandatory';
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
                        container.style.scrollSnapType = 'none';
                    },
                    onComplete: () => {
                        container.style.scrollSnapType = 'x mandatory';
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
                    container.style.scrollSnapType = 'none';
                },
                onComplete: () => {
                    container.style.scrollSnapType = 'x mandatory';
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
            <h3 class="dark:text-pale-night-white text-xl font-bold text-gray-700">{{ $title }}</h3>
        @endif
    </div>

    <div 
        x-ref="container" 
        class="no-scrollbar relative w-full touch-pan-y snap-x snap-mandatory overflow-x-auto pb-8"
        style="scroll-padding-left: max(var(--padding), calc((100vw - 80rem) / 2 + var(--padding))); scroll-padding-right: max(var(--padding), calc((100vw - 80rem) / 2 + var(--padding)));"
    >
        <div class="flex w-max min-w-full flex-row flex-nowrap items-stretch gap-8 md:gap-12" style="padding-left: max(var(--padding), calc((100vw - 80rem) / 2 + var(--padding))); padding-right: max(var(--padding), calc((100vw - 80rem) / 2 + var(--padding)));">
            {{ $slot }}
        </div>
    </div>

    <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8 mt-4 flex justify-end gap-3">
        <flux:button
            icon="chevron-left"
            variant="ghost"
            x-on:click="prev()"
            aria-label="Previous"
            class="glass-pane size-10 flex items-center justify-center rounded-full text-pale-night-black/70 dark:text-pale-night-white transition-all hover:scale-110 active:scale-95"
        />
        <flux:button
            icon="chevron-right"
            variant="ghost"
            x-on:click="next()"
            aria-label="Next"
            class="glass-pane size-10 flex items-center justify-center rounded-full text-pale-night-black/70 dark:text-pale-night-white transition-all hover:scale-110 active:scale-95"
        />
    </div>
</div>
