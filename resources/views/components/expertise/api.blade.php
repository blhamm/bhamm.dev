<div class="expertise-animation-container absolute inset-0 z-0 opacity-70 dark:opacity-60 scale-90 md:scale-115 origin-bottom-right translate-x-12 translate-y-8 md:translate-x-20 md:translate-y-12" data-type="api">
    <svg viewBox="0 0 400 300" class="h-full w-full" preserveAspectRatio="xMaxYMax slice">
        <defs>
            <filter id="api-glow" x="-50%" y="-50%" width="200%" height="200%">
                <feGaussianBlur stdDeviation="2.5" result="blur" />
                <feMerge>
                    <feMergeNode in="blur" />
                    <feMergeNode in="SourceGraphic" />
                </feMerge>
            </filter>
        </defs>
        
        <!-- Connection Paths focused on lower-right -->
        <path class="api-path fill-none stroke-pale-night-blue/40 stroke-1" d="M 220 250 L 320 190 L 380 230" />
        <path class="api-path fill-none stroke-pale-night-purple/40 stroke-1" d="M 280 260 L 350 210 L 390 180" />
        <path class="api-path fill-none stroke-pale-night-teal/40 stroke-1" d="M 240 190 L 300 220 L 360 180" />
        <path class="api-path fill-none stroke-pale-night-blue/40 stroke-1" d="M 330 250 L 260 210 L 220 250" />
        <path class="api-path fill-none stroke-pale-night-purple/40 stroke-1" d="M 370 215 L 320 190 L 240 190" />
        
        <!-- Nodes/LEDs (More nodes added) -->
        <circle class="api-node fill-pale-night-blue" cx="220" cy="250" r="3" filter="url(#api-glow)" />
        <circle class="api-node fill-pale-night-purple" cx="320" cy="190" r="4" filter="url(#api-glow)" />
        <circle class="api-node fill-pale-night-teal" cx="380" cy="230" r="3" filter="url(#api-glow)" />
        <circle class="api-node fill-pale-night-blue" cx="280" cy="260" r="2" filter="url(#api-glow)" />
        <circle class="api-node fill-pale-night-purple" cx="350" cy="210" r="3" filter="url(#api-glow)" />
        <circle class="api-node fill-pale-night-teal" cx="390" cy="180" r="5" filter="url(#api-glow)" />
        <circle class="api-node fill-pale-night-blue" cx="240" cy="190" r="3" filter="url(#api-glow)" />
        <circle class="api-node fill-pale-night-purple" cx="300" cy="220" r="2" filter="url(#api-glow)" />
        <circle class="api-node fill-pale-night-teal" cx="360" cy="180" r="4" filter="url(#api-glow)" />
        <circle class="api-node fill-pale-night-blue" cx="330" cy="250" r="2.5" filter="url(#api-glow)" />
        <circle class="api-node fill-pale-night-purple" cx="260" cy="210" r="3" filter="url(#api-glow)" />
        <circle class="api-node fill-pale-night-teal" cx="370" cy="215" r="2" filter="url(#api-glow)" />

        <!-- Data packets (will be animated) -->
        <circle class="packet fill-pale-night-teal opacity-0" r="2" filter="url(#api-glow)" />
        <circle class="packet fill-pale-night-blue opacity-0" r="2" filter="url(#api-glow)" />
        <circle class="packet fill-pale-night-purple opacity-0" r="2" filter="url(#api-glow)" />
    </svg>
</div>
