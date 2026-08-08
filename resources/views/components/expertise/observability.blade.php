<div class="expertise-animation-container absolute inset-0 z-0 opacity-70 dark:opacity-60 scale-125 origin-bottom-right translate-x-12 translate-y-6 md:translate-x-20 md:translate-y-10" data-type="observability">
    <svg viewBox="0 0 400 300" class="h-full w-full" preserveAspectRatio="xMaxYMax slice">
        <defs>
            <filter id="obs-glow" x="-50%" y="-50%" width="200%" height="200%">
                <feGaussianBlur stdDeviation="3" result="coloredBlur" />
                <feMerge>
                    <feMergeNode in="coloredBlur" />
                    <feMergeNode in="SourceGraphic" />
                </feMerge>
            </filter>
        </defs>

        <!-- Monitoring Hub Decorative Rings -->
        <g class="obs-hub-decoration">
            <circle class="fill-none stroke-blh-orange/20 stroke-[0.5]" cx="330" cy="210" r="50" />
            <circle class="fill-none stroke-pale-night-red/10 stroke-[0.5]" cx="330" cy="210" r="65" />
        </g>
        
        <!-- Symmetrical Connection Paths -->
        <g class="obs-paths">
            <!-- Top -->
            <path class="obs-path stroke-pale-night-red/30 stroke-1 fill-none" d="M 330 140 L 330 185" stroke-dasharray="4,4" />
            <!-- Top Right -->
            <path class="obs-path stroke-blh-orange/30 stroke-1 fill-none" d="M 390 175 L 355 195" stroke-dasharray="4,4" />
            <!-- Bottom Right -->
            <path class="obs-path stroke-pale-night-yellow/30 stroke-1 fill-none" d="M 390 245 L 355 225" stroke-dasharray="4,4" />
            <!-- Bottom -->
            <path class="obs-path stroke-pale-night-red/30 stroke-1 fill-none" d="M 330 280 L 330 235" stroke-dasharray="4,4" />
            <!-- Bottom Left -->
            <path class="obs-path stroke-blh-orange/30 stroke-1 fill-none" d="M 270 245 L 305 225" stroke-dasharray="4,4" />
            <!-- Top Left -->
            <path class="obs-path stroke-pale-night-yellow/30 stroke-1 fill-none" d="M 270 175 L 305 195" stroke-dasharray="4,4" />
        </g>

        <!-- Data Packets -->
        <g class="obs-packets">
            <circle class="obs-packet fill-pale-night-red" r="2.5" cx="330" cy="140" />
            <circle class="obs-packet fill-blh-orange" r="2.5" cx="390" cy="175" />
            <circle class="obs-packet fill-pale-night-yellow" r="2.5" cx="390" cy="245" />
            <circle class="obs-packet fill-pale-night-red" r="2.5" cx="330" cy="280" />
            <circle class="obs-packet fill-blh-orange" r="2.5" cx="270" cy="245" />
            <circle class="obs-packet fill-pale-night-yellow" r="2.5" cx="270" cy="175" />
        </g>

        <!-- Main Hub Body -->
        <circle class="obs-central fill-none stroke-blh-orange/40 stroke-1" cx="330" cy="210" r="35" />
        
        <!-- Gauge (Centered) -->
        <g class="obs-gauge" transform="translate(330, 210)">
            <path class="gauge-arc fill-none stroke-pale-night-yellow/40 stroke-2" d="M -18 0 A 18 18 0 0 1 18 0" />
            <path class="gauge-arc-track fill-none stroke-pale-night-red/20 stroke-2" d="M -18 0 A 18 18 0 0 0 18 0" opacity="0.5" />
            <line class="gauge-needle stroke-blh-orange stroke-2" x1="0" y1="0" x2="0" y2="-15" />
            <circle class="fill-pale-night-red" cx="0" cy="0" r="2.5" />
        </g>

        <!-- Peripheral Nodes -->
        <g class="obs-node-group">
            <circle class="obs-pulse fill-pale-night-red/30" cx="330" cy="140" r="5" />
            <circle class="obs-node fill-pale-night-red" cx="330" cy="140" r="5" filter="url(#obs-glow)" />
            <circle class="obs-led fill-white" cx="330" cy="140" r="1.5" />
        </g>
        <g class="obs-node-group">
            <circle class="obs-pulse fill-blh-orange/30" cx="390" cy="175" r="4" />
            <circle class="obs-node fill-blh-orange" cx="390" cy="175" r="4" filter="url(#obs-glow)" />
            <circle class="obs-led fill-white" cx="390" cy="175" r="1" />
        </g>
        <g class="obs-node-group">
            <circle class="obs-pulse fill-pale-night-yellow/30" cx="390" cy="245" r="5" />
            <circle class="obs-node fill-pale-night-yellow" cx="390" cy="245" r="5" filter="url(#obs-glow)" />
            <circle class="obs-led fill-white" cx="390" cy="245" r="2" />
        </g>
        <g class="obs-node-group">
            <circle class="obs-pulse fill-pale-night-red/30" cx="330" cy="280" r="4" />
            <circle class="obs-node fill-pale-night-red" cx="330" cy="280" r="4" filter="url(#obs-glow)" />
            <circle class="obs-led fill-white" cx="330" cy="280" r="1.5" />
        </g>
        <g class="obs-node-group">
            <circle class="obs-pulse fill-blh-orange/30" cx="270" cy="245" r="4" />
            <circle class="obs-node fill-blh-orange" cx="270" cy="245" r="4" filter="url(#obs-glow)" />
            <circle class="obs-led fill-white" cx="270" cy="245" r="1" />
        </g>
        <g class="obs-node-group">
            <circle class="obs-pulse fill-pale-night-yellow/30" cx="270" cy="175" r="5" />
            <circle class="obs-node fill-pale-night-yellow" cx="270" cy="175" r="5" filter="url(#obs-glow)" />
            <circle class="obs-led fill-white" cx="270" cy="175" r="2" />
        </g>
    </svg>
</div>
