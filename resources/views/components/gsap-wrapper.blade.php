@props([
    'animation' => 'fade-up', // fade-up, fade-in, scale-up
    'start' => 'top 85%',
    'end' => 'bottom 15%',
    'scrub' => false,
    'duration' => 1,
    'delay' => 0,
])

<div
    x-data="{
    init() {
        const config = {
            scrollTrigger: {
                trigger: this.$el,
                start: '{{ $start }}',
                end: '{{ $end }}',
                scrub: {{ $scrub ? 'true' : 'false' }},
            },
            duration: {{ $duration }},
            delay: {{ $delay }},
            ease: 'power3.out'
        };

        if ('{{ $animation }}' === 'fade-up') {
            gsap.from(this.$el, { ...config, y: 50, autoAlpha: 0 });
        } else if ('{{ $animation }}' === 'fade-in') {
            gsap.from(this.$el, { ...config, autoAlpha: 0 });
        } else if ('{{ $animation }}' === 'scale-up') {
            gsap.from(this.$el, { ...config, scale: 0.9, autoAlpha: 0 });
        }
    }
}"
    {{ $attributes }}
>
    {{ $slot }}
</div>
