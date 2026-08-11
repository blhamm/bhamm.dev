@props(['speed' => 40])

<div
    x-data="{
    init() {
        const content = this.$refs.content;
        
        const startMarquee = () => {
            if (this.marqueeStarted) return;
            this.marqueeStarted = true;

            const clone = content.cloneNode(true);
            this.$el.appendChild(clone);
            
            gsap.to([content, clone], {
                xPercent: -100,
                duration: {{ $speed }},
                ease: 'none',
                repeat: -1
            });
        };

        this.marqueeStarted = false;

        const imgs = content.querySelectorAll('img');
        if (imgs.length === 0) {
            startMarquee();
        } else {
            let loaded = 0;
            const checkDone = () => {
                loaded++;
                if (loaded >= imgs.length) startMarquee();
            };
            imgs.forEach(img => {
                if (img.complete) {
                    checkDone();
                } else {
                    img.addEventListener('load', checkDone);
                    img.addEventListener('error', checkDone);
                }
            });
            // Final check in case they all completed before we added listeners
            if (loaded >= imgs.length) startMarquee();
        }
    }
}"
    {{ $attributes->merge(['class' => 'relative overflow-hidden w-full  flex flex-row flex-nowrap']) }}
>
    <div x-ref="content" class="flex shrink-0 flex-row flex-nowrap items-center gap-24 px-12">{{ $slot }}</div>
</div>
