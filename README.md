# bhamm.dev

[![Laravel](https://img.shields.io/badge/Laravel-13.x-ff2d20?style=flat-square&logo=laravel)](https://laravel.com)
[![Livewire Volt](https://img.shields.io/badge/Livewire_4_&_Volt-4e46e5?style=flat-square&logo=livewire)](https://laravel.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-v4-38bdf8?style=flat-square&logo=tailwindcss)](https://tailwindcss.com)
[![GSAP](https://img.shields.io/badge/GSAP-Animations-88ce02?style=flat-square&logo=greensock)](https://greensock.com)

The official website for [Brandon Hamm](https://bhamm.dev), built with modern web technologies focusing on high-end performance, fluid GSAP animations, modular component architecture, and interactive visitor features.

---

##  Core Stack

- **Backend:** Laravel 13 (PHP 8.4+)
- **Frontend Framework:** Livewire 4 with Volt (Single File Components) & Blade components
- **Styling:** Tailwind CSS v4 & Flux UI component library
- **Animations:** GSAP (GreenSock Animation Platform) with ScrollTrigger & Timelines
- **Smooth Scrolling:** Lenis smooth scroll integration
- **Mapping & Geocoding:** Apple MapKit JS, Geocodio, and MaxMind GeoIP2

---

## Architecture & Key Features

### 1. Modular Vertical Architecture
- Transitioned from experimental horizontal/sticky layouts to a clean, highly performant vertical flow.
- Organized into discrete, reusable sections and components.

### 2. Component-Based Design
- **Structural:** `Header`, `Footer`, `Content` (wrapper), `SectionNav`.
- **Media & Cards:** `Hero`, `Carousel`, `Card`, `ProjectCard`, `Media` (with responsive `srcset` support), `VideoComponent`, `Modal`, `Marquee`, `Tag`.
- **Logic:** `GsapWrapper` for declarative GSAP animation bindings.

### 3. Advanced GSAP Animations & Scrolling
- **Staggered Entries:** Carousel items utilize GSAP ScrollTrigger for smooth entry animations with `expo.out` easing.
- **Seamless Marquees:** Infinite, jerk-free brand logo loops.
- **Dynamic Color Tween** Header brand suffixes smoothly cycle through color palettes using GSAP keyframes.
- **Cinematic Scroll-Scaled Images & SVG Text Masks:** Scroll-synced timelines coordinating scale, border radius, padding, and high-precision SVG text masks for immersive visual reveals.

### 4. Interactive Guestbook & Map (`guestbook-map`)
- **Apple MapKit JS Integration:** Fully interactive mapping with custom dark/light theme styling and layer toggles (Signees vs. Recent Visitors).
- **Click-to-Interact Safety Overlay:** Prevents accidental scroll trapping while reading the page, activating full map controls on click.
- **Defense-in-Depth Container Clipping:** Combines CSS paint containment (`contain: paint`), `clip-path`, and active runtime `MutationObserver` to ensure GPU-accelerated MapKit canvas elements strictly respect rounded container corners (`rounded-3xl`) across Safari, Chrome, and Firefox.

### 5. Theme Management
- **Alpine.js Driven:** Theme state managed directly on the `<html>` element to eliminate FOUC (Flash of Unstyled Content) without complex server storage for guests.
