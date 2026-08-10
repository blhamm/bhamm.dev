# Performance Analysis: Expertise Card Animations

The expertise card animations are architected with a **"High Impact, Low Footprint"** strategy. While they provide a premium visual experience, their actual resource consumption is strictly managed through several layers of optimization.

## 1. The "Zero-Cost" Idle State
The most significant performance feature is the **Visibility-Based Lifecycle** implemented in `expertise-animations.js`.
- **Intersection Observer:** Every card animation container is monitored. The moment a card leaves the viewport (or is hidden behind a modal), its associated GSAP timelines are completely **killed** using `gsap.killTweensOf()`.
- **Resource Recovery:** This means if the user is focused on the Hero section or the About section, the expertise animations are consuming **0% CPU** and **zero battery**. They only "wake up" when they are actually visible to the user.

## 2. Technical Resource Impact

| Resource Type | Impact Level | Description |
| :--- | :--- | :--- |
| **CPU (JavaScript)** | **Low** | GSAP handles the math for coordinates and attribute morphing (like in the Frontend component). These calculations are extremely efficient and share a single `requestAnimationFrame` loop. |
| **GPU (Rendering)** | **Moderate** | This is the primary "cost." Several animations (API, DevOps, Observability) use SVG filters for glowing effects. These filters are recalculated by the GPU during movement, which is the most energy-intensive part of the process. |
| **Battery (Mobile)** | **Low-Moderate** | Because the carousel typically only shows 1–2 cards at a time on mobile, the total number of active GPU-rendered layers is strictly capped, preventing device heating or significant drain. |
| **Memory** | **Negligible** | The animations are purely SVG-based. They don't require large bitmap buffers or complex data structures, keeping the memory footprint very light. |

## 3. Key Optimizations Used
- **Hardware Acceleration:** Animations primarily target `transform` (Translate/Rotate) and SVG `attributes` rather than layout properties, allowing the browser to offload work to the GPU and avoid expensive "reflows."
- **Conflict Prevention:** By killing tweens on visibility changes and modal triggers, we prevent "zombie" animations from stacking or competing for resources in the background.
- **Canvas vs. SVG:** We intentionally use **Canvas** for the global "Dot Matrix" background to handle thousands of dots, while reserving **SVG** for the card animations where precise control over complex paths and morphing is required.

## 4. Comparison to Global Effects
The card animations are actually **less expensive** than the `Particles` background or the `Dot Matrix` waves, as those effects cover the entire viewport surface. The card animations are localized "hotspots" of activity that are intelligently managed to ensure the site remains smooth and responsive, even on lower-powered devices.
