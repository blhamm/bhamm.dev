<div class="expertise-animation-container absolute inset-0 z-0 opacity-70 dark:opacity-60 scale-125 origin-bottom-right translate-x-12 translate-y-6 md:translate-x-20 md:translate-y-10" data-type="laravel">
    <svg viewBox="0 0 400 300" class="h-full w-full" preserveAspectRatio="xMaxYMax slice">
        <defs>
            <filter id="laravel-glow" x="-50%" y="-50%" width="200%" height="200%">
                <feGaussianBlur stdDeviation="3" result="blur" />
                <feMerge>
                    <feMergeNode in="blur" />
                    <feMergeNode in="SourceGraphic" />
                </feMerge>
            </filter>
        </defs>

        <!-- Laravel logo in lower right -->
        <g class="laravel-logo-group" filter="url(#laravel-glow)">
            <!-- Main Logo from public/images/laravel.svg -->
            <g transform="translate(280, 200) scale(2)">
                <path class="laravel-path stroke-pale-night-red stroke-[1.5]" d="M41 9.88889L33 5.44444L25 9.88889M41 9.88889L33 14.3333M41 9.88889V18.7778L33 23.2222M25 9.88889V18.7778M25 9.88889L33 14.3333M25 18.7778L33 23.2222M25 18.7778L9 27.6667M33 23.2222V32.1111L17 41M33 23.2222V14.3333M33 23.2222L17 32.1111M9 27.6667L17 32.1111M9 27.6667V9.88889M1 5.44444L9 1L17 5.44444M1 5.44444V32.1111L17 41M1 5.44444L9 9.88889M17 41V32.1111M9 9.88889L17 5.44444M17 5.44444V23.2222" fill="none" />
            </g>
        </g>
        
        <!-- Pulsing nodes around -->
        <circle class="laravel-node fill-pale-night-red" cx="280" cy="220" r="3" filter="url(#laravel-glow)" />
        <circle class="laravel-node fill-pale-night-red" cx="370" cy="220" r="3" filter="url(#laravel-glow)" />
        <circle class="laravel-node fill-pale-night-red" cx="370" cy="280" r="3" filter="url(#laravel-glow)" />
        <circle class="laravel-node fill-pale-night-red" cx="280" cy="280" r="3" filter="url(#laravel-glow)" />
        <circle class="laravel-node fill-pale-night-red" cx="325" cy="200" r="2" filter="url(#laravel-glow)" />
        <circle class="laravel-node fill-pale-night-red" cx="325" cy="300" r="2" filter="url(#laravel-glow)" />

        <!-- Floating floating dots -->
        <circle class="laravel-float-dot fill-pale-night-red/40" cx="300" cy="240" r="1.5" />
        <circle class="laravel-float-dot fill-pale-night-red/40" cx="350" cy="260" r="2" />
        <circle class="laravel-float-dot fill-pale-night-red/40" cx="320" cy="270" r="1" />
        <circle class="laravel-float-dot fill-pale-night-red/40" cx="340" cy="230" r="1.5" />
        <circle class="laravel-float-dot fill-pale-night-red/40" cx="290" cy="260" r="2" />
    </svg>
</div>
