# Safari RequestAnimationFrame (RAF) Optimization & Particle Stutter Fix

## Overview
This document outlines the investigation and technical resolution for Safari-specific rendering stutters and sub-100ms pauses in canvas particle loops on mobile (iOS Safari) and desktop Safari.

## The Problem
While non-WebKit browsers (Chrome, Firefox, Edge) maintained smooth 60fps particle simulation and rendering, Safari and mobile iOS Safari experienced noticeable fractional-second pauses (sub-100ms stutters) in particle progression during `requestAnimationFrame` (RAF) cycles. 

### Root Causes Identified
1. **Delta Time Unit Mismatch**: 
   - GSAP ticker provides `deltaTime` in **seconds** (e.g., `0.0166` for 60fps).
   - The particle engine (`particles.js`) originally treated `deltaTime` as milliseconds without conversion (`deltaTime * 1000`), leading to incorrect low-pass filtering and erratic delta calculations.
2. **Accumulator Reset Flaw (`physicsAccumulator = 0`)**:
   - When Safari throttled or delayed RAF callbacks during inertial scrolling, touch interactions, or background/foreground transitions, `deltaTime` spiked.
   - The original implementation used an `if (physicsAccumulator >= PHYSICS_STEP)` check that zeroed out the accumulator (`physicsAccumulator = 0`) rather than draining it step-by-step. This discarded accumulated time whenever a frame dropped or lagged, causing particles to freeze for a fraction of a second.
3. **WebKit Timer Coalescing & Throttling**:
   - Mobile Safari aggressively coalesces timers and delays rAF during touch/scroll events. Without a fixed-timestep accumulator drain (`while (physicsAccumulator >= PHYSICS_STEP)`), physics simulation fell out of sync with real-world elapsed time.

## The Solution
1. **Explicit Unit Conversion**:
   - Convert GSAP ticker seconds to milliseconds immediately: `const dtMs = deltaTime * 1000;`.
2. **Robust Delta Clamping & Smoothing**:
   - Clamp delta to a safe upper bound (`Math.min(dtMs, 50)`) to prevent physics explosions after lag spikes.
   - Apply a stable low-pass filter (`lastTime = (lastTime * 0.8) + (clampedDelta * 0.2);`) to smooth out Safari's jittery timer intervals.
3. **Fixed-Timestep Accumulator Drainage (`while` Loop)**:
   - Replaced the single `if` check with a robust `while` loop that drains `physicsAccumulator` in fixed steps (`PHYSICS_STEP = 1000 / 120`):
     ```javascript
     while (physicsAccumulator >= PHYSICS_STEP) {
         physicsAccumulator -= PHYSICS_STEP;
         // update movement and physics per step
     }
     ```
   - This ensures zero time loss during Safari rAF throttling or dropouts, perfectly eliminating sub-100ms pauses while preserving buttery-smooth motion across all mobile and desktop browsers.
