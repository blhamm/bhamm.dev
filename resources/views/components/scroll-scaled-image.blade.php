@props([
    'src' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?ixlib=rb-4.0.3&auto=format&fit=crop&w=2880&q=80',
    'alt' => 'Development Workspace',
])

@php
    $maskId = 'mask-'.Str::random(8);
@endphp

<div
    x-data="{
        init() {
            const container = this.$refs.imgContainer;
            const wrapper = this.$el;
            const img = this.$refs.img;
            const mask = this.$refs.mask;
            const elephant = this.$refs.elephant;
            const elephantBob = this.$refs.elephantBob;
            const elephantImg = this.$refs.elephantImg;

            const getStartScale = () => {
                const vw = window.innerWidth;
                const vh = window.innerHeight;

                // Use offsetWidth/Height to get untransformed layout dimensions
                // This prevents jitter during ScrollTrigger.refresh()
                const width = container.offsetWidth;
                const height = container.offsetHeight;

                return Math.max(vw / width, vh / height);
            };

            let currentDirection = 1;

            const tl = gsap.timeline({
                scrollTrigger: {
                    trigger: wrapper,
                    start: 'top top',
                    end: '+=350%', // Extended to accommodate sequential mask reveal + elephant run
                    scrub: true, // Direct 1:1 sync with Lenis smooth scroll (avoids compound lag)
                    pin: true,
                    pinSpacing: true,
                    invalidateOnRefresh: true,
                    anticipatePin: 0,
                    onUpdate: (self) => {
                        // Flip elephant orientation instantly on direction change without tween allocation / RAF desync
                        if (elephantImg && self.direction !== currentDirection) {
                            currentDirection = self.direction;
                            gsap.set(elephantImg, {
                                scaleX: currentDirection === -1 ? -1 : 1,
                            });
                        }
                    },
                },
            });

            // Initial states
            gsap.set(mask, { scale: 16, transformOrigin: 'center center', force3D: true });
            gsap.set(elephant, { autoAlpha: 0, x: '120vw' });

            // Phase 1: Framing zoom out (0.0 -> 0.8)
            tl.fromTo(
                container,
                {
                    scale: () => getStartScale(),
                    transformOrigin: 'top center',
                    borderRadius: '0rem',
                },
                {
                    scale: 1,
                    borderRadius: '2.5rem',
                    ease: 'power2.inOut',
                    duration: 0.8,
                },
                0,
            );

            tl.fromTo(
                img,
                {
                    scale: 2,
                    yPercent: -10,
                },
                {
                    scale: 1.2,
                    yPercent: 0,
                    ease: 'power2.inOut',
                    duration: 0.8,
                },
                0,
            );

            // Container downward translation for header clearance (0.0 -> 2.3)
            tl.fromTo(
                container,
                { y: 0 },
                {
                    y: () => (window.innerWidth < 768 ? '4rem' : '10rem'),
                    ease: 'power2.inOut',
                    duration: 2.3,
                },
                0,
            );

            // Phase 2: Mask reveal (The 'Flying through the mask' effect) (0.8 -> 2.3)
            tl.to(
                mask,
                {
                    scale: 1,
                    force3D: true,
                    ease: 'power2.inOut',
                    duration: 1.5,
                },
                0.8,
            );

            // Final image settling zoom (0.8 -> 2.3)
            tl.to(
                img,
                {
                    scale: 1,
                    ease: 'power2.inOut',
                    duration: 1.5,
                },
                0.8,
            );

            // Settle container slightly for depth (0.8 -> 2.3)
            tl.to(
                container,
                {
                    scale: 0.96,
                    transformOrigin: 'top center',
                    ease: 'power2.inOut',
                    duration: 1.5,
                },
                0.8,
            );

            // Phase 3: Fast Elephant Running Animation (2.3 -> 3.8)
            // Make visible right before entering screen
            tl.set(elephant, { autoAlpha: 1 }, 2.25);

            // X-axis translation & scaling on outer elephant container
            tl.fromTo(
                elephant,
                { x: '120vw', scale: 0.9 },
                {
                    x: '-120vw',
                    scale: 1.15,
                    ease: 'power1.inOut',
                    duration: 1.5,
                },
                2.3,
            );

            // Y-axis bobbing on inner elephantBob wrapper (isolates transforms and prevents matrix conflicts)
            tl.fromTo(
                elephantBob,
                { y: 0 },
                {
                    y: -28,
                    repeat: 3,
                    yoyo: true,
                    ease: 'sine.inOut',
                    duration: 0.375, // 0.375 * 4 = 1.5s exactly matches the run duration
                },
                2.3,
            );

            // Hide offscreen elephant after run finishes
            tl.set(elephant, { autoAlpha: 0 }, 3.85);

            // Recalculate ScrollTrigger measurements
            setTimeout(() => ScrollTrigger.refresh(), 100);
        },
    }"
    class="z-10 flex min-h-[70vh] w-full flex-col items-center justify-start overflow-hidden md:min-h-screen"
    {{ $attributes }}
>
    <div
        x-ref="imgContainer"
        class="relative h-[60vh] w-[94%] max-w-7xl overflow-hidden rounded-[2.5rem] will-change-transform md:h-[80vh]"
    >
        <img x-ref="img" src="{{ $src }}" alt="{{ $alt }}" class="h-full w-full object-cover" />

        {{-- The Theme Background Mask --}}
        <div x-ref="mask" class="pointer-events-none absolute inset-0 z-10 will-change-transform" aria-hidden="true">
            <svg viewBox="0 0 2000 1000" preserveAspectRatio="xMidYMid slice" class="h-full w-full" shape-rendering="geometricPrecision" style="
                    overflow: hidden;
                ">
                <defs>
                    <mask id="{{ $maskId }}">
                        <rect x="-10" y="-10" width="2100" height="1100" fill="white" />
                        <text
                            x="1000"
                            y="500"
                            text-anchor="middle"
                            dominant-baseline="middle"
                            fill="black"
                            font-size="300"
                            class="text-[120px] md:text-[300px]"
                            font-weight="900"
                            style="
                                font-family:
                                    ui-sans-serif,
                                    system-ui,
                                    -apple-system,
                                    BlinkMacSystemFont,
                                    'Segoe UI',
                                    Roboto,
                                    'Helvetica Neue',
                                    Arial,
                                    sans-serif;
                            "
                        >
                            SHIP IT!
                        </text>
                    </mask>
                </defs>
                {{-- currentColor resolves to the theme bg colors via Tailwind classes --}}
                <rect
                    x="-10"
                    y="-10"
                    width="2100"
                    height="1100"
                    fill="currentColor"
                    mask="url(#{{ $maskId }})"
                    class="text-pale-night-white dark:text-pale-night-black"
                />
            </svg>
        </div>

        <div class="from-pale-night-black/20 pointer-events-none absolute inset-0 bg-linear-to-t to-transparent"></div>
    </div>

    {{-- Fast PHP Elephant (Runs Right to Left across the screen as mask reaches final scale) --}}
    <div x-ref="elephant" class="pointer-events-none absolute top-1/2 z-30 flex items-center will-change-transform opacity-0">
        {{-- Bobbing wrapper to isolate Y transforms from X translation --}}
        <div x-ref="elephantBob" class="relative flex items-center will-change-transform">
            {{-- Fast, lightweight badge without backdrop-filter or continuous CSS animation overhead --}}
            <div class="absolute -top-10 -left-6 md:-top-12 md:-left-8 bg-white/95 dark:bg-pale-night-darker/95 border border-zinc-200/80 dark:border-zinc-700/80 shadow-lg font-brand text-pale-night-black dark:text-pale-night-white text-xs md:text-sm font-extrabold px-3.5 py-1.5 md:px-4 md:py-2 rounded-2xl whitespace-nowrap">
                🐘 WITH PHP!
            </div>
            <img x-ref="elephantImg" src="/images/fast_elephant.webp" alt="Fast PHP Elephant" class="w-32 md:w-52 h-auto object-contain" />
        </div>
    </div>
</div>
