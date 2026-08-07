<div class="expertise-animation-container absolute inset-0 z-0 opacity-70 dark:opacity-60 scale-125 origin-bottom-right" data-type="observability">
    <svg viewBox="0 0 400 300" class="h-full w-full" preserveAspectRatio="xMidYMid slice">
        <defs>
            <filter id="obs-glow" x="-50%" y="-50%" width="200%" height="200%">
                <feGaussianBlur stdDeviation="2" result="blur" />
                <feMerge>
                    <feMergeNode in="blur" />
                    <feMergeNode in="SourceGraphic" />
                </feMerge>
            </filter>
            <radialGradient id="obs-radar" cx="50%" cy="50%" r="50%">
                <stop offset="0%" stop-color="var(--color-pale-night-red)" stop-opacity="0.3" />
                <stop offset="100%" stop-color="var(--color-pale-night-red)" stop-opacity="0" />
            </radialGradient>
        </defs>

        <!-- Scanning Beam -->
        <circle class="obs-scan fill-none stroke-pale-night-red/40 stroke-1" cx="340" cy="240" r="10" />
        <circle class="obs-scan fill-none stroke-pale-night-red/20 stroke-1" cx="340" cy="240" r="30" />
        <circle class="obs-scan fill-none stroke-pale-night-red/10 stroke-1" cx="340" cy="240" r="50" />

        <!-- Monitoring nodes focused in lower right -->
        <circle class="obs-central fill-pale-night-red/20 stroke-pale-night-red/40 stroke-1" cx="340" cy="240" r="35" />
        
        <!-- Simplified Gauge inside center -->
        <g class="obs-gauge" transform="translate(340, 240)">
            <path class="gauge-arc fill-none stroke-pale-night-red/40 stroke-2" d="M -15 0 A 15 15 0 0 1 15 0" />
            <line class="gauge-needle stroke-pale-night-red stroke-2" x1="0" y1="0" x2="0" y2="-12" />
            <circle class="fill-pale-night-red" cx="0" cy="0" r="2" />
        </g>

        <!-- Metric Bars inside hub -->
        <g class="obs-metrics" transform="translate(330, 255)">
            <rect class="metric-bar fill-pale-night-red/40" x="0" y="0" width="3" height="10" rx="1" />
            <rect class="metric-bar fill-pale-night-red/60" x="6" y="-3" width="3" height="13" rx="1" />
            <rect class="metric-bar fill-pale-night-red/40" x="12" y="2" width="3" height="8" rx="1" />
            <rect class="metric-bar fill-pale-night-red/60" x="18" y="-1" width="3" height="11" rx="1" />
        </g>
        
        <line class="obs-line stroke-pale-night-red/50 stroke-1" x1="280" y1="200" x2="315" y2="225" stroke-dasharray="4,4" />
        <line class="obs-line stroke-pale-night-red/50 stroke-1" x1="380" y1="180" x2="355" y2="210" stroke-dasharray="4,4" />
        <line class="obs-line stroke-pale-night-red/50 stroke-1" x1="260" y1="270" x2="315" y2="255" stroke-dasharray="4,4" />
        <line class="obs-line stroke-pale-night-red/50 stroke-1" x1="390" y1="280" x2="365" y2="265" stroke-dasharray="4,4" />
        <line class="obs-line stroke-pale-night-red/50 stroke-1" x1="310" y1="210" x2="325" y2="220" stroke-dasharray="4,4" />
        <line class="obs-line stroke-pale-night-red/50 stroke-1" x1="360" y1="265" x2="350" y2="255" stroke-dasharray="4,4" />

        <!-- Floating nodes with LEDs -->
        <g class="obs-node-group">
            <circle class="obs-node fill-pale-night-red" cx="280" cy="200" r="4" filter="url(#obs-glow)" />
            <circle class="obs-led fill-white" cx="280" cy="200" r="1.5" />
        </g>
        <g class="obs-node-group">
            <circle class="obs-node fill-pale-night-red" cx="380" cy="180" r="3" filter="url(#obs-glow)" />
            <circle class="obs-led fill-white" cx="380" cy="180" r="1" />
        </g>
        <g class="obs-node-group">
            <circle class="obs-node fill-pale-night-red" cx="260" cy="270" r="5" filter="url(#obs-glow)" />
            <circle class="obs-led fill-white" cx="260" cy="270" r="2" />
        </g>
        <g class="obs-node-group">
            <circle class="obs-node fill-pale-night-red" cx="390" cy="280" r="4" filter="url(#obs-glow)" />
            <circle class="obs-led fill-white" cx="390" cy="280" r="1.5" />
        </g>
        <g class="obs-node-group">
            <circle class="obs-node fill-pale-night-red" cx="310" cy="210" r="3" filter="url(#obs-glow)" />
            <circle class="obs-led fill-white" cx="310" cy="210" r="1" />
        </g>
        <g class="obs-node-group">
            <circle class="obs-node fill-pale-night-red" cx="360" cy="265" r="2" filter="url(#obs-glow)" />
            <circle class="obs-led fill-white" cx="360" cy="265" r="0.5" />
        </g>
    </svg>
</div>
