# Project Baseline: blhamm.com Rebuild

## Core Stack
- **Backend:** Laravel 12
- **Frontend Framework:** Livewire 3 with Volt (Single File Components)
- **Styling:** Tailwind CSS v4
- **UI Components:** Flux UI
- **Animations:** GSAP (GreenSock Animation Platform)
- **Smooth Scrolling:** Lenis

## Project Requirements
1. **Vertical Architecture:** Transition from experimental horizontal/sticky layout to a modular, vertical flow.
2. **Component-Based Design:** Implement a robust library of reusable Livewire Volt components.
3. **Declarative Animations:** Use a `GsapWrapper` component to handle GSAP logic in a declarative way.
4. **Interactive Features:**
    - Particle canvas background.
    - Full-screen Intro Animation (Typing effect).
    - Scroll-synced video via GSAP.
    - Dark/Light mode support.
5. **Navigation:** Flexible `SectionNav` supporting multiple modes (tabs, pill, sticky, etc.).

## Phase 1: Cleanup
- Remove legacy sticky scroll logic and GSAP triggers from `welcome.blade.php` and `app.js`.
- Establish a clean vertical scroll baseline.

## Phase 2: Component Library
- **Structural:** `Header`, `Footer`, `Content` (wrapper), `SectionNav`.
- **Media:** `Hero`, `Carousel`, `Card`, `ProjectCard`, `Media` (with srcset support), `VideoComponent`, `Modal`, `Marquee`, `Tag`.
- **Logic:** `GsapWrapper`.

## Phase 3: Expertise Redesign
- **Visual Overhaul:** Transition from static images to high-end GSAP animations.
- **Glass-Morphism:** Shared "terminal" container for the expertise cards to maintain a clean interface.
- **Animated Gradient:** Continuous animated background for the section using the brand palette.
- **Micro-Animations:** Topic-specific animations for each card (Observability, API, DB, Laravel, DevOps, Engineering, Frontend).


## Recent Updates & Technical Implementation

### Theme Management
- **OS Preference First:** The site defaults to the user's OS color scheme using `window.matchMedia('(prefers-color-scheme: dark)')`.
- **Alpine.js Driven:** Theme state is managed by an Alpine.js `x-data` object on the `<html>` element. This ensures immediate application and avoids flickering (FOUC) without requiring heavy server-side logic or complex storage for the landing page.
- **Unified Toggle:** A single theme toggle button in the header switches between light and dark modes for the current session.

### Componentization (Blade vs Livewire)
- **Performance Optimized:** Static sections like Header, Footer, and Content have been migrated from Livewire to Blade components to reduce overhead.
- **Declarative UI:** Repetitive elements like Project Cards and Tags are encapsulated in Blade components, keeping `welcome.blade.php` clean and readable.

### Animations (GSAP)
- **Staggered Entry:** Carousel items use GSAP and ScrollTrigger for a premium "falling into place" entry animation with `expo.out` easing.
- **Seamless Marquee:** The `x-marquee` component uses GSAP to create an infinite, jerk-free loop of brand logos.
- **Dynamic Color Tweens:** The `.dev` suffix in the header brand name smoothly cycles through the Pale Night color palette using GSAP keyframes.
- **Complex Pinning Transitions:** The `x-scroll-scaled-image` component utilizes a GSAP Timeline synced to a single ScrollTrigger. This allows simultaneous animation of scale, border radius, and padding. It features a cinematic "Text Mask" reveal where the camera appears to fly backwards through a theme-colored mask (e.g., revealing the word 'SHIP IT!') to reveal the image behind it. High-precision SVG masks and optimized scaling factors (20x) are used to ensure a seamless "flying through" effect without edge artifacts. The transition is coordinated across multiple phases (Framing -> Mask Reveal -> Settling) to maintain perfect header clearance and depth.

### Best Practices for Scroll Animations
1. **Use Timelines for Synchronization:** Instead of multiple independent `ScrollTrigger` instances, use a single `gsap.timeline` to coordinate multiple properties. This ensures they stay in perfect sync during scrubbing.
2. **Phase-Based Transitions:** For complex entry animations (like full-viewport to framed), split the logic into phases (e.g., Framing -> Settling). This prevents visual "fighting" between different properties like `scale` and `padding`.
3. **Smooth Scrubbing:** Use `scrub: 1` (or a numeric value) to add a slight smoothing catch-up to scroll-synced animations, even when using Lenis.
4. **Anticipate Pinning:** Use `anticipatePin: 1` to reduce visual jerks when an element transitions into a pinned state.
5. **Responsive Scaling:** Use functions (like `getStartScale()`) and `invalidateOnRefresh: true` to ensure animations adapt to window resize events.
6. **Layout-Independent Measurements:** Use `offsetWidth/Height` instead of `getBoundingClientRect()` when calculating dimensions for initial scale transformations. This ensures that `invalidateOnRefresh` calculations remain accurate even if the element is already scaled or translated.
7. **Animate Layout & Transform Separately:** Combining `scale` transforms with `y` translations or child margins creates a more depth-aware transition than scaling alone. Avoid animating layout properties (like `paddingTop`) on the pinned element itself to prevent position jitter.
8. **Transform Origin:** Use `transformOrigin: 'top center'` when scaling pinned elements from full-viewport to container size to prevent them from peeking above the sticky header.
9. **Layering (Z-Index):** Carefully manage `z-index` for pinned elements to ensure they don't overlap headers or get buried under subsequent content.
10. **Reserve Space for Pinned Elements:** Use `h-screen` or `min-h-screen` on the root of pinned components to ensure `pinSpacing` correctly reserves the full viewport and prevents subsequent sections from being obscured by the pinning container.
12. **SVG Text Masks for Reveals:** Use SVG `<mask>` elements with `fill="currentColor"` on a surrounding rectangle to create "holes" that reveal underlying content. This is more robust than CSS `mask-image` for complex "flying through" animations. Ensure the SVG `viewBox` is wide enough to contain the full text at the target font size, matching the container's aspect ratio to prevent clipping when `preserveAspectRatio="slice"` is used.
13. **Staggered Multi-Phase Timelines:** For complex reveals (e.g., Frame -> Mask Reveal), use overlapping timeline offsets (like `0.8`) to ensure transitions between phases feel fluid rather than clinical.
14. **Stable Pinning:** When an element is pinned, avoid any property animations that change its layout footprint. Use `y` (transform: translate) to move content within the pinned area to ensure perfectly smooth, jitter-free scrolling.
15. **Prevent Viewport Overflow:** When scaling elements to cover the full viewport (e.g., zoom-out effects), add `overflow-hidden` to the root component wrapper. This prevents horizontal scrollbars caused by sub-pixel rounding or extreme scaling.
16. **Safari Mask Stability:** High-scale SVG masks in Safari can be prone to "poking through" artifacts. Use oversized masking rectangles (e.g., 2% larger than the viewBox) and apply `-webkit-mask-image: -webkit-radial-gradient(white, black);` to the container to force clean clipping in WebKit. *Note: This can conflict with SVG masks in Chrome; ensure it is applied only when necessary or conditionally.*
17. **Chrome Texture Size Limits:** Extreme scales (e.g., 100x) can exceed browser compositor limits (16k/32k pixels), causing artifacts or rendering failures. Aim for lower scales (e.g., 20x-30x) combined with larger base dimensions/font sizes to achieve the same visual depth.
18. **Avoid Mixing Masking Types:** In Chrome (Blink), combining CSS `-webkit-mask-image` on a parent with an SVG `<mask>` on a child can lead to flicker and update issues. Prefer one consistent masking method.
19. **GSAP force3D for SVG:** Use `force3D: false` in GSAP tweens for SVG elements that are being scaled significantly, to prevent Chrome from rasterizing them at low resolutions and then scaling the bitmap. Also remove `will-change: transform` from the mask element itself if visual flashes occur during high-scale transitions in Chrome.

## Future Sections Plan

### 1. Scroll-Scaled Hero Image
- **Location:** Above the Experience (Carousel) section.
- **Behavior:** A widescreen image (16:9) that starts at 100% viewport width and scales down to match the main container width as the user scrolls.
- **Styling:** Transitions from square corners to rounded corners (e.g., `rounded-3xl`) as it reaches its final resting state.
- **Tech:** GSAP ScrollTrigger linked to scroll position.

### 2. Symmetrical Bento Grid
- **Location:** Above the About Me section.
- **Structure:** A pyramid-style bento grid using a mix of small, medium, and large tiles.
- **Content:** Primarily brand logos, tech stack icons, and minimal copy to illustrate partnerships and tools.
- **Design:** Clean, balanced symmetry following modern bento best practices.

## Design Specifications

### Dark Mode BG Colors (Tailwind)
- **Primary BG:** `bg-pale-night-black` (#292D3E)
- **Secondary BG:** `bg-pale-night-darker` (#212432)
- **Primary Text:** `text-pale-night-white` (#fefefe)
- **Borders/Cards:** `dark:border-zinc-800`

### Asset Export Guidelines
| Screen Type | DPI | Dimension (Width) | Recommendation |
|-------------|-----|-------------------|----------------|
| Mobile      | 1x  | 375px             | JPG/WebP 80%   |
| Mobile      | 2x  | 750px             | `@2x` Assets   |
| Desktop     | 1x  | 1440px            | `@1x` Assets   |
| Desktop     | 2x  | 2880px            | `@2x` Assets   |
| Card Images | -   | 800px / 1600px    | Use `x-media`  |

### Media Implementation
Use the `<x-media>` component to handle responsive assets:
```html
<x-media 
    src="/img/project.jpg" 
    srcset="/img/project-375.jpg 375w, /img/project-750.jpg 750w, /img/project-1440.jpg 1440w"
    alt="Project description"
/>
```
