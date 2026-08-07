<div class="expertise-animation-container absolute inset-0 z-0 opacity-70 dark:opacity-60 scale-125 origin-bottom-right translate-x-12 translate-y-12 md:translate-x-20 md:translate-y-20" data-type="frontend">
    <svg viewBox="0 0 400 300" class="h-full w-full" preserveAspectRatio="xMaxYMax slice">
        <defs>
            <filter id="fe-glow" x="-50%" y="-50%" width="200%" height="200%">
                <feGaussianBlur stdDeviation="2" result="blur" />
                <feMerge>
                    <feMergeNode in="blur" />
                    <feMergeNode in="SourceGraphic" />
                </feMerge>
            </filter>
        </defs>

        <!-- UI blocks in lower right -->
        <g class="fe-ui-group">
            <rect class="fe-container fill-pale-night-teal/10 stroke-pale-night-teal/30 stroke-1" x="220" y="200" width="160" height="80" rx="8" />
            <rect class="fe-top-bar fill-pale-night-teal/20 stroke-pale-night-teal/50 stroke-1" x="235" y="215" width="40" height="10" rx="2" />
            <rect class="fe-content fill-pale-night-teal/20 stroke-pale-night-teal/50 stroke-1" x="235" y="235" width="130" height="30" rx="4" />
        </g>
        
        <!-- Interactive nodes -->
        <circle class="fe-node fill-pale-night-teal" cx="230" cy="210" r="3" filter="url(#fe-glow)" />
        <circle class="fe-node fill-pale-night-teal" cx="370" cy="270" r="3" filter="url(#fe-glow)" />
        
        <!-- LEDs -->
        <circle class="fe-led fill-white" cx="230" cy="210" r="1.5" />
        <circle class="fe-led fill-white" cx="370" cy="270" r="1.5" />
    </svg>
</div>
