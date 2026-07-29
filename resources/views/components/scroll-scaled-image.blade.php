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

            const getStartScale = () => {
                const vw = window.innerWidth;
                const vh = window.innerHeight;

                // Use offsetWidth/Height to get untransformed layout dimensions
                // This prevents jitter during ScrollTrigger.refresh()
                const width = container.offsetWidth;
                const height = container.offsetHeight;

                return Math.max(vw / width, vh / height);
            };

            const tl = gsap.timeline({
                scrollTrigger: {
                    trigger: wrapper,
                    start: 'top top',
                    end: '+=250%', // Extended for the mask reveal
                    scrub: 1, // Smoothing catch-up
                    pin: true,
                    pinSpacing: true,
                    invalidateOnRefresh: true,
                    anticipatePin: 1,
                },
            });

            // A single, smooth 'Ken Burns' zoom out transition
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
                    duration: 1,
                },
            );

            // Initial state for the mask (zoomed to cover viewport without exceeding GPU limits)
            gsap.set(mask, { scale: 20, transformOrigin: 'center center', force3D: false });

            tl.fromTo(
                img,
                {
                    scale: 2, // Start with a deeper zoom
                    yPercent: -10,
                },
                {
                    scale: 1.2, // Mid-point zoom
                    yPercent: 0,
                    ease: 'power2.inOut',
                    duration: 1,
                },
                0, // Start at same time as container
            );

            // Move space clearing to 'y' on the container to avoid jitter on pinned element
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

            // Phase 2: Mask reveal (The 'Flying through the mask' effect)
            // Starts slightly before phase 1 ends for a seamless flow
            tl.to(
                mask,
                {
                    scale: 1,
                    force3D: false,
                    ease: 'power2.inOut',
                    duration: 1.5,
                },
                0.8,
            );

            // Final image settling zoom
            tl.to(
                img,
                {
                    scale: 1,
                    ease: 'power2.inOut',
                    duration: 1.5,
                },
                0.8,
            );

            // Settle the container slightly for depth
            // Maintain consistent transformOrigin to avoid position jumps
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

            // Ensure all scroll triggers are recalculated after the pinning setup
            setTimeout(() => ScrollTrigger.refresh(), 100);
        },
    }"
    class="z-10 flex min-h-[70vh] w-full flex-col items-center justify-start overflow-hidden md:min-h-screen"
    {{ $attributes }}
>
    <div
        x-ref="imgContainer"
        class="relative h-[60vh] w-[94%] max-w-7xl overflow-hidden rounded-[2.5rem] will-change-transform md:h-[80vh]"
        style="-webkit-mask-image: -webkit-radial-gradient(white, black)"
    >
        <img x-ref="img" src="{{ $src }}" alt="{{ $alt }}" class="h-full w-full object-cover" />

        {{-- The Theme Background Mask --}}
        <div x-ref="mask" class="pointer-events-none absolute inset-0 z-10 origin-center" aria-hidden="true">
            <svg viewBox="0 0 2000 1000" preserveAspectRatio="xMidYMid slice" class="h-full w-full" shape-rendering="geometricPrecision" style="
                    overflow: hidden;
                ">
                <defs>
                    <mask id="{{ $maskId }}">
                        <rect x="-10" y="-10" width="2020" height="1020" fill="white" />
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
                    width="2020"
                    height="1020"
                    fill="currentColor"
                    mask="url(#{{ $maskId }})"
                    class="text-pale-night-white dark:text-pale-night-black"
                />
            </svg>
        </div>

        <div class="from-pale-night-black/20 pointer-events-none absolute inset-0 bg-linear-to-t to-transparent"></div>
    </div>
</div>
