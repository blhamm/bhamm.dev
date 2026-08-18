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

===

<laravel-boost-guidelines>
=== foundation rules ===

# Laravel Boost Guidelines

The Laravel Boost guidelines are specifically curated by Laravel maintainers for this application. These guidelines should be followed closely to ensure the best experience when building Laravel applications.

## Foundational Context

This application is a Laravel application running on PHP 8.5. You are an expert with the Laravel ecosystem. Always use the APIs that match the installed major version of each package — do not assume a version.

Before relying on a package's API, confirm its installed version:
- PHP packages: run `composer show --direct` to list direct dependencies with versions, or `composer show <vendor/package>` for a single package.
- JS packages: check `package.json` for the installed versions.

## Skills Activation

This project has domain-specific skills available in `**/skills/**`. You MUST activate the relevant skill whenever you work in that domain—don't wait until you're stuck.

## Conventions

- You must follow all existing code conventions used in this application. When creating or editing a file, check sibling files for the correct structure, approach, and naming.
- Use descriptive names for variables and methods. For example, `isRegisteredForDiscounts`, not `discount()`.
- Check for existing components to reuse before writing a new one.

## Verification Scripts

- Do not create verification scripts or tinker when tests cover that functionality and prove they work. Unit and feature tests are more important.

## Application Structure & Architecture

- Stick to existing directory structure; don't create new base folders without approval.
- Do not change the application's dependencies without approval.

## Frontend Bundling

- If the user doesn't see a frontend change reflected in the UI, it could mean they need to run `npm run build`, `npm run dev`, or `composer run dev`. Ask them.

## Documentation Files

- You must only create documentation files if explicitly requested by the user.

## Replies

- Be concise in your explanations - focus on what's important rather than explaining obvious details.

=== boost rules ===

# Laravel Boost

## Tools

- Laravel Boost is an MCP server with tools designed specifically for this application. Prefer Boost tools over manual alternatives like shell commands or file reads.
- Use `database-query` to run read-only queries against the database instead of writing raw SQL in tinker.
- Use `database-schema` to inspect table structure before writing migrations or models.
- Use `get-absolute-url` to resolve the correct scheme, domain, and port for project URLs. Always use this before sharing a URL with the user.
- Use `browser-logs` to read browser logs, errors, and exceptions. Only recent logs are useful, ignore old entries.

## Searching Documentation (IMPORTANT)

- Use `search-docs` before changes that depend on Laravel ecosystem APIs, behavior, configuration, or version-specific syntax. Skip it for copy-only edits and other changes where package documentation is irrelevant. Reuse sufficient results already in context instead of searching again.
- Pass a `packages` array to scope results when you know which packages are relevant.
- Use multiple broad, topic-based queries: `['rate limiting', 'routing rate limiting', 'routing']`. Expect the most relevant results first.
- Do not add package names to queries because package info is already shared. Use `test resource table`, not `filament 4 test resource table`.

### Search Syntax

1. Use words for auto-stemmed AND logic: `rate limit` matches both "rate" AND "limit".
2. Use `"quoted phrases"` for exact position matching: `"infinite scroll"` requires adjacent words in order.
3. Combine words and phrases for mixed queries: `middleware "rate limit"`.
4. Use multiple queries for OR logic: `queries=["authentication", "middleware"]`.

## Project Rules

- This project contains committed, area-grouped rules in `.ai/rules` when that directory exists (settled decisions, non-obvious traps, standing constraints). Framework and package guidelines that only apply to specific paths (testing, frontend, components) also live there, under `.ai/rules/boost` — this is not just recorded decisions, it is load-bearing guidance you have not seen inline. Before you enter plan mode or create/edit any file, you MUST first: open @.ai/rules/index.md (it maps file globs to rule files), read every rule file whose globs cover the path(s) in scope, and run `grep -rin 'keyword' .ai/rules` to catch what a path match alone misses. Do not write code until you have read and are following every matching rule. If `.ai/rules` does not exist, continue without it.
- Record durable rules with `record-rule` so the next agent or teammate inherits them instead of working them out again. Pass a `glob` (e.g. `app/Http/Controllers/**`), a short `title`, and a few-line `note`. Always use `record-rule`, never your native memory or notes tool — native memory is personal and session-scoped; only `.ai/rules` is shared with the team and persists in the repo.

## Artisan

- Run Artisan commands directly via the command line (e.g., `php artisan route:list`). Use `php artisan list` to discover available commands and `php artisan [command] --help` to check parameters.
- Inspect routes with `php artisan route:list`. Filter with: `--method=GET`, `--name=users`, `--path=api`, `--except-vendor`, `--only-vendor`.
- Read configuration values using dot notation: `php artisan config:show app.name`, `php artisan config:show database.default`. Or read config files directly from the `config/` directory.

## Tinker

- Execute PHP in app context for debugging and testing code. Do not create models without user approval, prefer tests with factories instead. Prefer existing Artisan commands over custom tinker code.
- Always use single quotes to prevent shell expansion: `php artisan tinker --execute 'Your::code();'`
  - Double quotes for PHP strings inside: `php artisan tinker --execute 'User::where("active", true)->count();'`

=== php rules ===

# PHP

- Always use curly braces for control structures, even for single-line bodies.
- Use PHP 8 constructor property promotion: `public function __construct(public GitHub $github) { }`. Do not leave empty zero-parameter `__construct()` methods unless the constructor is private.
- Use explicit return type declarations and type hints for all method parameters: `function isAccessible(User $user, ?string $path = null): bool`
- Use TitleCase for Enum keys: `FavoritePerson`, `BestLake`, `Monthly`.
- Prefer PHPDoc blocks over inline comments. Only add inline comments for exceptionally complex logic.
- Use array shape type definitions in PHPDoc blocks.

=== deployments rules ===

# Deployment

- Laravel can be deployed using [Laravel Cloud](https://cloud.laravel.com/), which is the fastest way to deploy and scale production Laravel applications.

=== tests rules ===

# Test Enforcement

- Every change must be programmatically tested. Write a new test or update an existing test, then run the affected tests to make sure they pass.
- Run the minimum number of tests needed to ensure code quality and speed. Use `php artisan test --compact` with a specific filename or filter.

=== laravel/core rules ===

# Do Things the Laravel Way

- Use `php artisan make:` commands to create new files (i.e. migrations, controllers, models, etc.). You can list available Artisan commands using `php artisan list` and check their parameters with `php artisan [command] --help`.
- If you're creating a generic PHP class, use `php artisan make:class`.
- Pass `--no-interaction` to all Artisan commands to ensure they work without user input. You should also pass the correct `--options` to ensure correct behavior.

### Model Creation

- When creating new models, create useful factories and seeders for them too. Ask the user if they need any other things, using `php artisan make:model --help` to check the available options.

## APIs & Eloquent Resources

- For APIs, default to using Eloquent API Resources and API versioning unless existing API routes do not, then you should follow existing application convention.

## URL Generation

- When generating links to other pages, prefer named routes and the `route()` function.

## Testing

- When creating models for tests, use the factories for the models. Check if the factory has custom states that can be used before manually setting up the model.
- Faker: Use methods such as `$this->faker->word()` or `fake()->randomDigit()`. Follow existing conventions whether to use `$this->faker` or `fake()`.
- When creating tests, make use of `php artisan make:test [options] {name}` to create a feature test, and pass `--unit` to create a unit test. Most tests should be feature tests.

## Vite Error

- If you receive an "Illuminate\Foundation\ViteException: Unable to locate file in Vite manifest" error, you can run `npm run build` or ask the user to run `npm run dev` or `composer run dev`.

=== volt/core rules ===

# Livewire Volt

- Single-file Livewire components: PHP logic and Blade templates in one file.
- Always check existing Volt components to determine functional vs class-based style.
- IMPORTANT: Always use `search-docs` tool for version-specific Volt documentation and updated code examples.
- IMPORTANT: Activate `volt-development` every time you're working with a Volt or single-file component-related task.

=== pint/core rules ===

# Laravel Pint Code Formatter

- If you have modified any PHP files, you must run `vendor/bin/pint --dirty --format agent` before finalizing changes to ensure your code matches the project's expected style.
- Do not run `vendor/bin/pint --test --format agent`, simply run `vendor/bin/pint --format agent` to fix any formatting issues.

=== pest/core rules ===

## Pest

- This project uses Pest for testing. Create tests: `php artisan make:test --pest {name}`.
- The `{name}` argument should not include the test suite directory. Use `php artisan make:test --pest SomeFeatureTest` instead of `php artisan make:test --pest Feature/SomeFeatureTest`.
- Run tests: `php artisan test --compact` or filter: `php artisan test --compact --filter=testName`.
- Do NOT delete tests without approval.

</laravel-boost-guidelines>
