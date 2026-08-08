<div class="expertise-animation-container absolute inset-0 z-0 opacity-70 dark:opacity-60 scale-125 origin-bottom-right translate-x-12 translate-y-6 md:translate-x-20 md:translate-y-10" data-type="engineering">
    <svg viewBox="0 0 400 300" class="h-full w-full" preserveAspectRatio="xMaxYMax slice">
        <defs>
            <filter id="eng-glow" x="-50%" y="-50%" width="200%" height="200%">
                <feGaussianBlur stdDeviation="2" result="blur" />
                <feMerge>
                    <feMergeNode in="blur" />
                    <feMergeNode in="SourceGraphic" />
                </feMerge>
            </filter>
        </defs>

        <!-- Blueprint grid in lower right -->
        <g class="eng-grid">
            <line class="eng-line stroke-pale-night-blue/40 stroke-1" x1="200" y1="200" x2="400" y2="200" />
            <line class="eng-line stroke-pale-night-blue/40 stroke-1" x1="200" y1="240" x2="400" y2="240" />
            <line class="eng-line stroke-pale-night-blue/40 stroke-1" x1="200" y1="280" x2="400" y2="280" />
            <line class="eng-line stroke-pale-night-blue/40 stroke-1" x1="240" y1="180" x2="240" y2="300" />
            <line class="eng-line stroke-pale-night-blue/40 stroke-1" x1="280" y1="180" x2="280" y2="300" />
            <line class="eng-line stroke-pale-night-blue/40 stroke-1" x1="320" y1="180" x2="320" y2="300" />
            <line class="eng-line stroke-pale-night-blue/40 stroke-1" x1="360" y1="180" x2="360" y2="300" />
        </g>

        <!-- Engineering nodes -->
        <circle class="eng-node fill-pale-night-blue" cx="240" cy="200" r="3" filter="url(#eng-glow)" />
        <circle class="eng-node fill-pale-night-blue" cx="320" cy="240" r="4" filter="url(#eng-glow)" />
        <circle class="eng-node fill-pale-night-blue" cx="280" cy="280" r="3" filter="url(#eng-glow)" />
        <circle class="eng-node fill-pale-night-blue" cx="360" cy="200" r="3" filter="url(#eng-glow)" />

        <!-- Glow LEDs -->
        <circle class="eng-led fill-white" cx="240" cy="200" r="1" />
        <circle class="eng-led fill-white" cx="320" cy="240" r="1.5" />
    </svg>
</div>
