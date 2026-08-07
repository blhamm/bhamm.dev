<div class="expertise-animation-container absolute inset-0 z-0 opacity-70 dark:opacity-60 scale-125 origin-bottom-right translate-x-12 translate-y-12 md:translate-x-20 md:translate-y-20" data-type="database">
    <svg viewBox="0 0 400 300" class="h-full w-full" preserveAspectRatio="xMaxYMax slice">
        <defs>
            <filter id="db-glow" x="-50%" y="-50%" width="200%" height="200%">
                <feGaussianBlur stdDeviation="2" result="blur" />
                <feMerge>
                    <feMergeNode in="blur" />
                    <feMergeNode in="SourceGraphic" />
                </feMerge>
            </filter>
        </defs>
        
        <!-- Database layers / Stack in bottom right -->
        <g class="db-layer-group">
            <rect class="db-layer fill-pale-night-yellow/10 stroke-pale-night-yellow/30 stroke-1" x="250" y="260" width="120" height="20" rx="4" />
            <circle class="db-led fill-pale-night-yellow" cx="260" cy="270" r="2" filter="url(#db-glow)" />
            <circle class="db-led fill-pale-night-yellow" cx="360" cy="270" r="2" filter="url(#db-glow)" />
        </g>
        
        <g class="db-layer-group">
            <rect class="db-layer fill-pale-night-yellow/15 stroke-pale-night-yellow/40 stroke-1" x="260" y="235" width="100" height="20" rx="4" />
            <circle class="db-led fill-pale-night-yellow" cx="270" cy="245" r="2" filter="url(#db-glow)" />
            <circle class="db-led fill-pale-night-yellow" cx="350" cy="245" r="2" filter="url(#db-glow)" />
        </g>
        
        <g class="db-layer-group">
            <rect class="db-layer fill-pale-night-yellow/20 stroke-pale-night-yellow/50 stroke-1" x="270" y="210" width="80" height="20" rx="4" />
            <circle class="db-led fill-pale-night-yellow" cx="280" cy="220" r="2" filter="url(#db-glow)" />
            <circle class="db-led fill-pale-night-yellow" cx="340" cy="220" r="2" filter="url(#db-glow)" />
        </g>

        <!-- Data flow lines -->
        <line class="db-flow stroke-pale-night-yellow/40 stroke-1" x1="280" y1="210" x2="280" y2="280" stroke-dasharray="1,3" />
        <line class="db-flow stroke-pale-night-yellow/40 stroke-1" x1="340" y1="210" x2="340" y2="280" stroke-dasharray="1,3" />
    </svg>
</div>
