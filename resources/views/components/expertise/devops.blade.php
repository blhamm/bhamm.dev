<div class="expertise-animation-container absolute inset-0 z-0 opacity-70 dark:opacity-60 scale-125 origin-bottom-right translate-x-12 translate-y-12 md:translate-x-20 md:translate-y-20" data-type="devops">
    <svg viewBox="0 0 400 300" class="h-full w-full" preserveAspectRatio="xMaxYMax slice">
        <defs>
            <filter id="devops-glow" x="-100%" y="-100%" width="300%" height="300%">
                <feGaussianBlur stdDeviation="3" result="blur" />
                <feMerge>
                    <feMergeNode in="blur" />
                    <feMergeNode in="SourceGraphic" />
                </feMerge>
            </filter>
        </defs>

        <!-- Pipeline paths in lower right -->
        <path class="devops-pipeline fill-none stroke-pale-night-green/40 stroke-1" d="M 250 250 C 250 200 350 200 350 250 S 250 300 250 250" />
        <path class="devops-pipeline fill-none stroke-pale-night-green/20 stroke-1" d="M 220 250 C 220 180 380 180 380 250 S 220 320 220 250" />
        
        <path class="devops-pipeline-active fill-none stroke-pale-night-green/40 stroke-2" d="M 250 250 C 250 200 350 200 350 250 S 250 300 250 250" stroke-dasharray="10,200" />
        <path class="devops-pipeline-active-2 fill-none stroke-pale-night-green/30 stroke-1" d="M 220 250 C 220 180 380 180 380 250 S 220 320 220 250" stroke-dasharray="5,150" />
        
        <circle class="devops-node fill-pale-night-green" cx="250" cy="250" r="4" filter="url(#devops-glow)" />
        <circle class="devops-node fill-pale-night-green" cx="350" cy="250" r="4" filter="url(#devops-glow)" />
        <circle class="devops-node fill-pale-night-green" cx="300" cy="212.5" r="3" filter="url(#devops-glow)" />
        <circle class="devops-node fill-pale-night-green" cx="300" cy="287.5" r="3" filter="url(#devops-glow)" />
        <circle class="devops-node fill-pale-night-green" cx="220" cy="250" r="2" filter="url(#devops-glow)" />
        <circle class="devops-node fill-pale-night-green" cx="380" cy="250" r="2" filter="url(#devops-glow)" />

        <!-- Glow LEDs -->
        <circle class="devops-led fill-white" cx="250" cy="250" r="1.5" />
        <circle class="devops-led fill-white" cx="350" cy="250" r="1.5" />

        <!-- Status Indicator / Failure Signal -->
        <circle class="devops-status fill-pale-night-green" cx="300" cy="200" r="6" filter="url(#devops-glow)" />
        <circle class="devops-status-led fill-white" cx="300" cy="200" r="2" />

        <!-- Replicas / Auto-scaling -->
        <g class="devops-replicas">
            <rect class="devops-replica fill-pale-night-green/20 stroke-pale-night-green/40 stroke-1" x="270" y="260" width="15" height="15" rx="2" opacity="0" />
            <rect class="devops-replica fill-pale-night-green/20 stroke-pale-night-green/40 stroke-1" x="292" y="260" width="15" height="15" rx="2" opacity="0" />
            <rect class="devops-replica fill-pale-night-green/20 stroke-pale-night-green/40 stroke-1" x="315" y="260" width="15" height="15" rx="2" opacity="0" />
        </g>
    </svg>
</div>
