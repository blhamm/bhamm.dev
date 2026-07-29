@props(['src' => '', 'pin' => true])

<div
    x-data="{
    init() {
        const video = this.$refs.video;

        video.addEventListener('loadedmetadata', () => {
            gsap.to(video, {
                scrollTrigger: {
                    trigger: this.$el,
                    start: 'top top',
                    end: 'bottom bottom',
                    scrub: true,
                    pin: {{ $pin ? 'true' : 'false' }},
                },
                currentTime: video.duration,
                ease: 'none'
            });
        });
    }
}"
    class="relative h-[200vh] w-full"
>
    <div class="sticky top-0 h-screen w-full overflow-hidden">
        <video
            x-ref="video"
            src="{{ $src }}"
            muted
            playsinline
            preload="auto"
            class="absolute inset-0 h-full w-full object-cover"
        ></video>
        <div class="bg-pale-night-darker/50 absolute inset-0 z-10"></div>
        <div class="relative z-20 flex h-full items-center justify-center">{{ $slot }}</div>
    </div>
</div>
