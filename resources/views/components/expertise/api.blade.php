<div class="expertise-animation-container absolute inset-0 z-0 opacity-70 dark:opacity-60 scale-125 origin-bottom-right translate-x-12 translate-y-12 md:translate-x-20 md:translate-y-20" data-type="api">
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
        <path class="api-path fill-none stroke-pale-night-blue/40 stroke-1" d="M 220 280 L 320 220 L 380 260" />
        <path class="api-path fill-none stroke-pale-night-purple/40 stroke-1" d="M 280 290 L 350 240 L 390 210" />
        <path class="api-path fill-none stroke-pale-night-teal/40 stroke-1" d="M 240 220 L 300 250 L 360 210" />
        <path class="api-path fill-none stroke-pale-night-blue/40 stroke-1" d="M 330 280 L 260 240 L 220 280" />
        <path class="api-path fill-none stroke-pale-night-purple/40 stroke-1" d="M 370 245 L 320 220 L 240 220" />
        
        <!-- Nodes/LEDs (More nodes added) -->
        <circle class="api-node fill-pale-night-blue" cx="220" cy="280" r="3" filter="url(#api-glow)" />
        <circle class="api-node fill-pale-night-purple" cx="320" cy="220" r="4" filter="url(#api-glow)" />
        <circle class="api-node fill-pale-night-teal" cx="380" cy="260" r="3" filter="url(#api-glow)" />
        <circle class="api-node fill-pale-night-blue" cx="280" cy="290" r="2" filter="url(#api-glow)" />
        <circle class="api-node fill-pale-night-purple" cx="350" cy="240" r="3" filter="url(#api-glow)" />
        <circle class="api-node fill-pale-night-teal" cx="390" cy="210" r="5" filter="url(#api-glow)" />
        <circle class="api-node fill-pale-night-blue" cx="240" cy="220" r="3" filter="url(#api-glow)" />
        <circle class="api-node fill-pale-night-purple" cx="300" cy="250" r="2" filter="url(#api-glow)" />
        <circle class="api-node fill-pale-night-teal" cx="360" cy="210" r="4" filter="url(#api-glow)" />
        <circle class="api-node fill-pale-night-blue" cx="330" cy="280" r="2.5" filter="url(#api-glow)" />
        <circle class="api-node fill-pale-night-purple" cx="260" cy="240" r="3" filter="url(#api-glow)" />
        <circle class="api-node fill-pale-night-teal" cx="370" cy="245" r="2" filter="url(#api-glow)" />

        <!-- Data packets (will be animated) -->
        <circle class="packet fill-pale-night-teal opacity-0" r="2" filter="url(#api-glow)" />
        <circle class="packet fill-pale-night-blue opacity-0" r="2" filter="url(#api-glow)" />
        <circle class="packet fill-pale-night-purple opacity-0" r="2" filter="url(#api-glow)" />
    </svg>
</div>
