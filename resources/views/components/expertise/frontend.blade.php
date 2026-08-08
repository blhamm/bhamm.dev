<div class="expertise-animation-container absolute inset-0 z-0 opacity-70 dark:opacity-60 scale-125 origin-bottom-right translate-x-12 translate-y-6 md:translate-x-20 md:translate-y-10" data-type="frontend">
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
            <rect class="fe-top-bar fill-pale-night-teal/20 stroke-pale-night-teal/50 stroke-1" x="235" y="212" width="130" height="6" rx="2" />
            
            <!-- Side bar representation -->
            <rect class="fe-sidebar fill-pale-night-teal/20 stroke-pale-night-teal/50 stroke-1" x="235" y="225" width="30" height="45" rx="2" />
            
            <!-- Main content representation -->
            <rect class="fe-content fill-pale-night-teal/20 stroke-pale-night-teal/50 stroke-1" x="270" y="225" width="95" height="45" rx="2" />
            
            <!-- Detail blocks in content -->
            <rect class="fe-detail fill-pale-night-teal/30" x="275" y="230" width="85" height="4" rx="1" />
            <rect class="fe-detail fill-pale-night-teal/30" x="275" y="238" width="60" height="4" rx="1" />
            <rect class="fe-detail fill-pale-night-teal/30" x="275" y="246" width="85" height="4" rx="1" />
            
            <!-- Small UI dots in top bar -->
            <circle class="fe-ui-dot fill-pale-night-teal/40" cx="240" cy="215" r="1.5" />
            <circle class="fe-ui-dot fill-pale-night-teal/40" cx="245" cy="215" r="1.5" />
            <circle class="fe-ui-dot fill-pale-night-teal/40" cx="250" cy="215" r="1.5" />
        </g>
        
        <!-- Interactive nodes - repositioned to align with UI -->
        <circle class="fe-node fill-pale-night-teal" cx="230" cy="205" r="3" filter="url(#fe-glow)" />
        <circle class="fe-node fill-pale-night-teal" cx="375" cy="275" r="3" filter="url(#fe-glow)" />
        
        <!-- LEDs -->
        <circle class="fe-led fill-white" cx="230" cy="205" r="1.5" />
        <circle class="fe-led fill-white" cx="375" cy="275" r="1.5" />
    </svg>
</div>
