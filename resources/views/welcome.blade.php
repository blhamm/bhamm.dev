<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    x-data="{
        darkMode: window.matchMedia('(prefers-color-scheme: dark)').matches,
        init() {
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
                this.darkMode = e.matches;
            });
        },
    }"
    :class="{ dark: darkMode }"
>
<head>
    @include('partials.head', ['title' => 'Brandon Hamm | blhamm.com'])
</head>
<body class="min-h-screen antialiased">
    <canvas id="particles" class="pointer-events-none fixed inset-0 z-0" aria-hidden="true"></canvas>

    <main id="app" class="relative z-10">
        {{-- Intro Section --}}
        <section id="hero" class="flex h-screen items-center justify-center">
            <div class="text-center">
                <div class="mb-4 flex items-center justify-center">
                    <div class="avatar-container relative h-0 w-0">
                        <div class="gradient opacity-0"></div>
                        <div id="avatar" class="h-0 w-0 opacity-0">
                            <img src="/images/me.jpg" alt="Brandon Hamm" class="rounded-full" />
                        </div>
                    </div>
                </div>
                <h1
                    class="typing-animation text-pale-night-black dark:text-pale-night-white text-2xl font-bold md:text-4xl"
                    id="hero-typing"
                >
                    Hey, I'm Brandon.
                </h1>
                <p class="scroll-helper-text text-pale-night-black/70 dark:text-pale-night-white/70 mt-4 text-xs opacity-0">
                    scroll to learn more
                </p>
            </div>
        </section>

        <x-header />

        <x-content>
            {{-- Scroll Scaled Image Section --}}
            <x-scroll-scaled-image src="/images/gradial.png" alt="Code on a screen" />

            <div class="relative z-20 mx-auto w-full max-w-7xl space-y-24 px-4 pb-24 sm:px-6 lg:px-8">
                <section id="expertise" class="space-y-8">
                    <x-carousel>
                        <x-slot name="header">
                    <h2 class="typing-animation text-pale-night-black dark:text-pale-night-white text-2xl font-bold md:mb-6 md:text-4xl">
                                Core Expertise & Systems
                            </h2>
                        </x-slot>

                        <x-project-card
                            title="API & Backend System Design"
                            description="Architecting resilient, discoverable APIs. Expert-level implementation of OAuth2, event-driven architectures, and distributed systems designed for high-throughput and failure tolerance."
                            image="/images/cloud.png"
                            :tags="['REST', 'OAuth', 'Redis', 'Event-Driven']"
                            size="w-xs md:w-xl"
                            modal="api-modal"
                        />

                        <x-project-card
                            title="Database Mastery & Data Layer"
                            description="Polyglot data strategy focusing on relational integrity and high-performance caching. From complex PostgreSQL schemas to low-latency Redis implementations, ensuring data safety and query efficiency."
                            image="/images/db.png"
                            :tags="['PostgreSQL', 'MySQL', 'Redis', 'SQLite']"
                            size="w-xs md:w-xl"
                            modal="database-modal"
                        />

                        <x-project-card
                            title="Observability & System Reliability"
                            description="Engineering for reliability through total visibility. Implementing OpenTelemetry (OTLP) for distributed tracing and metrics. Moving beyond simple monitoring to proactive system health."
                            image="/images/observability.png"
                            :tags="['Grafana', 'OTLP', 'Observability', 'SRE']"
                            size="w-xs md:w-xl"
                            modal="observability-modal"
                        />

                        <x-project-card
                            title="DevOps, Deployment & Infrastructure"
                            description="Infrastructure as code and container-native workflows. Streamlining delivery with GitHub Actions and Ansible. Building reproducible, self-healing environments across AWS and DigitalOcean."
                            image="/images/devops.png"
                            :tags="['Docker', 'AWS', 'GitHub Actions', 'Tailscale']"
                            size="w-xs md:w-xl"
                            modal="devops-modal"
                        />

                        <x-project-card
                            title="Laravel & PHP Expertise"
                            description="Deep-domain expertise in the Laravel ecosystem since v3.2. Architecting high-performance PHP applications by leveraging the framework's core strengths and knowing when to extend them."
                            image="/images/php.png"
                            :tags="['Laravel', 'PHP', 'Eloquent', 'Livewire']"
                            size="w-xs md:w-xl"
                            modal="laravel-modal"
                        />

                        <x-project-card
                            title="Engineering Standards & Craft"
                            description="Strict adherence to SOLID principles and type-safe development. Using testing (Pest/PHPUnit) as a primary design tool. Driving team velocity through clean code and strict static analysis."
                            image="/images/gradial.png"
                            :tags="['Testing', 'SOLID', 'PHPStan', 'TypeScript']"
                            size="w-xs md:w-xl"
                            modal="engineering-modal"
                        />

                        <x-project-card
                            title="Frontend Architecture & Design Systems"
                            description="Bridging high-end design with reactive engineering. Meticulous implementation of design systems using Vue, React, and Tailwind CSS. Crafting pixel-perfect, accessible interfaces from Figma to production."
                            image="/images/front-end.png"
                            :tags="['Vue', 'React', 'TypeScript', 'Tailwind']"
                            size="w-xs md:w-xl"
                            modal="frontend-modal"
                        />
                    </x-carousel>
                </section>

                <section id="highlights" class="space-y-8">
                    <x-bento-grid>
                        {{-- Row 1: Large Center --}}
                        <div class="bg-pale-night-black/5 ring-pale-night-black/10 flex min-h-[300px] flex-col items-center justify-center space-y-4 rounded-3xl border border-zinc-200 p-8 text-center ring-1 ring-inset md:col-span-6 md:col-start-4 dark:border-zinc-800">
                            <div class="flex size-16 items-center justify-center rounded-2xl bg-indigo-500/10">
                                <flux:icon.cpu-chip class="size-8 text-indigo-500" />
                            </div>
                            <div>
                                <flux:heading level="3" size="lg">Systems Architect</flux:heading>
                                <p class="text-pale-night-black/60 dark:text-pale-night-white/60 mt-2 max-w-sm">
                                    Architecting resilient, distributed systems that balance performance with long-term maintainability.
                                </p>
                            </div>
                        </div>

                        {{-- Row 2: Two Mediums --}}
                        <div class="bg-pale-night-black/5 ring-pale-night-black/10 flex items-center gap-6 rounded-3xl border border-zinc-200 p-8 ring-1 ring-inset md:col-span-5 md:col-start-2 dark:border-zinc-800">
                            <div class="flex size-12 shrink-0 items-center justify-center rounded-xl bg-green-500/10">
                                <flux:icon.command-line class="size-6 text-green-500" />
                            </div>
                            <div>
                                <flux:heading level="3" size="md">Backend Mastery</flux:heading>
                                <p class="text-pale-night-black/60 dark:text-pale-night-white/60 text-sm">
                                    High-performance APIs and mission-critical business logic.
                                </p>
                            </div>
                        </div>

                        <div class="bg-pale-night-black/5 ring-pale-night-black/10 flex items-center gap-6 rounded-3xl border border-zinc-200 p-8 ring-1 ring-inset md:col-span-5 dark:border-zinc-800">
                            <div class="flex size-12 shrink-0 items-center justify-center rounded-xl bg-blue-500/10">
                                <flux:icon.paint-brush class="size-6 text-blue-500" />
                            </div>
                            <div>
                                <flux:heading level="3" size="md">Frontend Finesse</flux:heading>
                                <p class="text-pale-night-black/60 dark:text-pale-night-white/60 text-sm">
                                    High-fidelity, interactive interfaces with a focus on UX.
                                </p>
                            </div>
                        </div>

                        {{-- Row 3: Four Smalls --}}
                        <div class="bg-pale-night-black/5 ring-pale-night-black/10 flex flex-col items-center space-y-3 rounded-3xl border border-zinc-200 p-6 text-center ring-1 ring-inset md:col-span-3 dark:border-zinc-800">
                            <img
                                src="https://upload.wikimedia.org/wikipedia/commons/9/93/Amazon_Web_Services_Logo.svg"
                                alt="AWS"
                                class="h-8 w-auto opacity-70 grayscale dark:invert"
                                aria-hidden="true"
                            />
                            <span class="text-pale-night-black/40 dark:text-pale-night-white/40 text-xs font-medium tracking-wider uppercase">Cloud</span>
                        </div>

                        <div class="bg-pale-night-black/5 ring-pale-night-black/10 flex flex-col items-center space-y-3 rounded-3xl border border-zinc-200 p-6 text-center ring-1 ring-inset md:col-span-3 dark:border-zinc-800">
                            <img
                                src="https://upload.wikimedia.org/wikipedia/commons/9/9a/Laravel.svg"
                                alt="Laravel"
                                class="h-8 w-auto opacity-70 grayscale dark:invert"
                                aria-hidden="true"
                            />
                            <span class="text-pale-night-black/40 dark:text-pale-night-white/40 text-xs font-medium tracking-wider uppercase">Logic</span>
                        </div>

                        <div class="bg-pale-night-black/5 ring-pale-night-black/10 flex flex-col items-center space-y-3 rounded-3xl border border-zinc-200 p-6 text-center ring-1 ring-inset md:col-span-3 dark:border-zinc-800">
                            <img
                                src="https://upload.wikimedia.org/wikipedia/commons/a/a7/React-icon.svg"
                                alt="React"
                                class="h-8 w-auto opacity-70 grayscale dark:invert"
                                aria-hidden="true"
                            />
                            <span class="text-pale-night-black/40 dark:text-pale-night-white/40 text-xs font-medium tracking-wider uppercase">Interface</span>
                        </div>

                        <div class="bg-pale-night-black/5 ring-pale-night-black/10 flex flex-col items-center space-y-3 rounded-3xl border border-zinc-200 p-6 text-center ring-1 ring-inset md:col-span-3 dark:border-zinc-800">
                            <img
                                src="https://upload.wikimedia.org/wikipedia/commons/3/33/Vercel_logo_2024.svg"
                                alt="Vercel"
                                class="h-8 w-auto opacity-70 grayscale dark:invert"
                                aria-hidden="true"
                            />
                            <span class="text-pale-night-black/40 dark:text-pale-night-white/40 text-xs font-medium tracking-wider uppercase">Deploy</span>
                        </div>
                    </x-bento-grid>
                </section>

                <x-gsap-wrapper animation="scale-up" :scrub="true">
                    <section
                        id="about"
                        class="bg-pale-night-black/5 ring-pale-night-black/10 rounded-3xl border border-zinc-200 p-12 ring-1 ring-inset dark:border-zinc-800"
                    >
                        <div class="grid items-center gap-12 md:grid-cols-2">
                            <div>
                                <flux:heading level="2" size="xl" class="typing-animation mb-4">About Me</flux:heading>
                                <p class="text-pale-night-black/75 dark:text-pale-night-white/70 text-lg leading-relaxed">
                                    I’ve been building for the web since 2008—long enough to remember when Flash was the
                                    future and IE6 was the final boss. I specialize in turning messy business
                                    requirements into clean, high-performance digital products. I'm the developer who
                                    cares about typography and the designer who writes their own migrations.
                                </p>
                            </div>
                            <div class="bg-pale-night-white/70 dark:bg-pale-night-black aspect-square rounded-2xl"></div>
                        </div>
                    </section>
                </x-gsap-wrapper>
            </div>

            {{-- Example of Video Component --}}
            {{-- <x-video-component src="/videos/scroll-bg.mp4">
                <flux:heading level="2" size="xl" class="typing-animation text-pale-night-white">Scroll to Control Time</flux:heading>
            </x-video-component> --}}

            <section id="experience" class="pt-12" aria-label="Brand Partnerships">
                <x-marquee>
                    <img
                        src="/images/brands/American_Express_logo.svg.png"
                        alt="American Express"
                        class="h-8 w-auto opacity-50 grayscale transition-opacity hover:opacity-100 md:h-12 dark:invert"
                    />
                    <img
                        src="/images/brands/Starbucks_Coffee_Logo.svg.png"
                        alt="Starbucks"
                        class="h-8 w-auto opacity-50 grayscale transition-opacity hover:opacity-100 md:h-12 dark:invert"
                    />
                    <img
                        src="/images/brands/Uber_logo_2018.svg.png"
                        alt="Uber"
                        class="h-4 w-auto opacity-50 grayscale transition-opacity hover:opacity-100 md:h-6 dark:invert"
                    />
                    <img
                        src="/images/brands/Chase_logo_2007.svg.png"
                        alt="Chase"
                        class="h-4 w-auto opacity-50 grayscale transition-opacity hover:opacity-100 md:h-6 dark:invert"
                    />
                    <img
                        src="/images/brands/United Logo_Rebrand_Large.svg"
                        alt="United Airlines"
                        class="h-4 w-auto opacity-50 grayscale transition-opacity hover:opacity-100 md:h-6 dark:invert"
                    />
                    <img
                        src="/images/brands/Emirates_Logo.svg.png"
                        alt="Emirates"
                        class="h-8 w-auto opacity-50 grayscale transition-opacity hover:opacity-100 md:h-12 dark:invert"
                    />
                    <img
                        src="/images/brands/Marriott_hotels_logo14.svg.png"
                        alt="Marriott"
                        class="h-8 w-auto opacity-50 grayscale transition-opacity hover:opacity-100 md:h-12 dark:invert"
                    />
                    <img
                        src="/images/brands/Lufthansa_Logo_2018.svg.png"
                        alt="Lufthansa"
                        class="h-4 w-auto opacity-50 grayscale transition-opacity hover:opacity-100 md:h-6 dark:invert"
                    />
                    <img
                        src="/images/brands/Air_Canada_2017.svg.png"
                        alt="Air Canada"
                        class="h-4 w-auto opacity-50 grayscale transition-opacity hover:opacity-100 md:h-6 dark:invert"
                    />
                    <img
                        src="/images/brands/Singapore_Airlines_Logo.svg.png"
                        alt="Singapore Airlines"
                        class="h-4 w-auto opacity-50 grayscale transition-opacity hover:opacity-100 md:h-6 dark:invert"
                    />
                    <img
                        src="/images/brands/Cathay_Pacific_logo.svg.png"
                        alt="Cathay Pacific"
                        class="h-4 w-auto opacity-50 grayscale transition-opacity hover:opacity-100 md:h-6 dark:invert"
                    />
                </x-marquee>
            </section>
        </x-content>

        <x-footer />
    </main>

    <x-modal name="frontend-modal" title="Frontend Architecture & Design Systems">
        <p>
            Modern UI must do more than look good—it must <em>think</em> and scale. I approach frontend development through
            the lens of design systems: component architecture, design tokens, and accessible patterns that provide
            long-term leverage for engineering teams.
        </p>
        <p>
            Fluent across the modern reactive landscape. <strong>Vue</strong> for elegant, maintainable codebases.
            <strong>React</strong> for ambitious product complexity. <strong>TypeScript</strong> throughout because
            runtime errors are solved problems. <strong>Tailwind</strong> because utility-first CSS is how you actually
            scale design systems without the fragile naming wars.
        </p>
        <p>
            But this isn’t just framework knowledge. My roots are in high-fidelity design tools like <strong>Figma</strong> and the <strong>Adobe Creative Cloud</strong>, so I understand the handoff from design to code as a continuity problem, not a translation problem. This
            means pixel-perfect implementation isn’t an afterthought; it’s baked into the architecture.
        </p>
        <p>
            A foundation in vanilla <strong>JavaScript</strong> and <strong>Modern CSS</strong> means I’m not
            framework-dependent. The fundamentals never stopped mattering. Accessibility isn’t a checklist—it’s a design
            constraint that makes everything better. Responsive systems work because they’re built with
            constraint-driven thinking, not media-query whack-a-mole.
        </p>
        <p>
            <strong>The Current Reality</strong>: Frontend is infrastructure. I build systems your backend team actually
            wants to integrate with: design tokens that sync with design tools and component APIs that feel intuitive.
            This is the era of type-safe frontends talking to type-safe backends.
        </p>
    </x-modal>

    <x-modal name="api-modal" title="API & Backend System Design">
        <p>
            Well-designed APIs are read like novels. They are about <em>discovery</em>—a developer should understand your system’s
            capabilities by exploring your endpoints, not by digging through stale documentation.
        </p>
        <p>
            <strong>REST API design</strong> done thoughtfully: semantic HTTP, appropriate status codes, and hypermedia hints
            where they add value. I build endpoints that compose well, scale in complex read/write patterns, and avoid becoming
            legacy technical debt.
        </p>
        <p>
            <strong>OAuth & Security</strong> expertise across all flavors—Authorization Code flows with PKCE for SPAs, and client credentials
            for service-to-service communication. This is security architecture that prioritizes safety without compromising developer experience.
        </p>
        <p>
            <strong>Event-Driven Architecture</strong> through queues and job systems. I decouple web requests from
            heavy lifting, designing for the reality of asynchronous operations. Redis queues, time-delayed jobs,
            and retry strategies that ensure system consistency and resilience.
        </p>
        <p>
            <strong>System Design Thinking</strong>: Analyzing load patterns, failure modes, and recovery strategies. I know when
            caching provides a boost and when it introduces risk. I build systems that degrade gracefully, maintaining consistency
            without unnecessary complexity.
        </p>
    </x-modal>

    <x-modal name="database-modal" title="Database Mastery & Data Layer">
        <p>
            Data persistence is the foundation of any serious application. Choosing the right tool for the access pattern is <em>essential</em>.
        </p>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div class="rounded-xl border border-zinc-100 bg-zinc-50 p-4 dark:border-zinc-800 dark:bg-zinc-800/50">
                <p class="mb-1 font-bold">Relational Ecosystem</p>
                <p class="text-sm opacity-80">
                    PostgreSQL, MySQL, SQL Server, and SQLite for ACID-compliant, structured data requirements.
                </p>
            </div>
            <div class="rounded-xl border border-zinc-100 bg-zinc-50 p-4 dark:border-zinc-800 dark:bg-zinc-800/50">
                <p class="mb-1 font-bold">In-Memory & Cache</p>
                <p class="text-sm opacity-80">
                    Redis for session management, real-time counters, leaderboards, and high-velocity rate limiting.
                </p>
            </div>
        </div>
        <p>
            <strong>Data Layer Thinking</strong>: Schema design that anticipates growth without over-engineering.
            Indexing as an art—balancing write performance with read velocity. Query optimization that starts with
            deeply understanding database execution plans and access patterns.
        </p>
    </x-modal>

    <x-modal name="devops-modal" title="DevOps, Deployment & Infrastructure">
        <p>
            Infrastructure is no longer a separate department—it's part of the application. <strong>Docker</strong> mastery means understanding image
            optimization, security scanning, and multi-stage builds to ensure lean, secure deployments.
        </p>
        <p>
            <strong>CI/CD Automation</strong> is the engine of velocity. GitHub Actions for modern workflows—matrix
            testing, artifact caching, and automated deployment gates. Ansible for reproducible configuration management that bridges the gap between dev and prod.
        </p>
        <p>
            <strong>Infrastructure as Code (IaC)</strong>: Using Terraform for cloud resource management ensures environment parity. Development should mirror production as closely as possible to eliminate "parity drift" bugs.
        </p>
        <p>
            <strong>Deployment Strategies</strong>: Implementing Blue-Green and Canary releases to provide zero-downtime rollouts and gradual confidence. I advocate for decoupling deployments from releases through feature flags.
        </p>
        <p>
            <strong>Zero-Trust Networking</strong>: Leveraging Tailscale for secure, identity-based infrastructure networking. Stop
            managing brittle firewall rules and start thinking in terms of verified identity.
        </p>
    </x-modal>

    <x-modal name="observability-modal" title="Observability & System Reliability">
        <p>
            You can't fix what you can't see. Modern observability is about understanding your
            system through high-cardinality telemetry, not just pretty dashboards.
        </p>
        <p>
            <strong>Grafana Stack</strong> for metrics and visualization. I focus on building dashboards that answer specific operational questions, ensuring scrape intervals and retention policies align with business needs.
        </p>
        <p>
            <strong>Distributed Tracing</strong> via OpenTelemetry (OTLP). When a performance issue arises, my observability stack allows for tracing requests across service boundaries—pinpointing bottlenecks in the frontend, API, or database with precision.
        </p>
        <p>
            <strong>Structured Logging</strong> as a mandatory discipline. JSON logs with consistent schemas make aggregation and
            searching via OpenObserve or Signoz actually effective, allowing for correlation across the entire request journey.
        </p>
        <p>
            <strong>SRE Mindset</strong>: Designing for failure. Timeouts, retries, and circuit breakers are core architectural components. Health checks should inform you of degradation <em>before</em> users experience it.
        </p>
        <p>
            <strong>Outcome-Based Alerting</strong>: Reducing alert fatigue by focusing on user-facing outcomes rather than system symptoms. Don't alert on CPU load—alert when request latency or error rates exceed acceptable thresholds.
        </p>
    </x-modal>

    <x-modal name="engineering-modal" title="Engineering Standards & Craft">
        <p>Engineering excellence starts with professional taste—knowing what "good" looks like and having the discipline to maintain it.</p>
        <p>
            <strong>Type Safety</strong> as a non-negotiable foundation. <strong>TypeScript</strong> on the frontend and
            <strong>PHPStan</strong> (at strict levels) on the backend. Types are documentation that the compiler enforces, communicating intent to both the machine and your future self.
        </p>
        <p>
            <strong>Testing as Design</strong>: Tests aren’t just for coverage; they are a primary design tool. <strong>PHPUnit</strong> and <strong>Pest</strong> for behavior specification, ensuring that refactoring can happen with confidence and speed.
        </p>
        <p><strong>SOLID Principles</strong> applied with pragmatic judgment:</p>
        <ul class="list-disc space-y-2 pl-5">
            <li><strong>Single Responsibility</strong>: Clear, focused purpose for every class.</li>
            <li><strong>Open/Closed</strong>: Architecture that welcomes extension without breakage.</li>
            <li><strong>Liskov Substitution</strong>: Reliable inheritance and contract fulfillment.</li>
            <li><strong>Interface Segregation</strong>: Lean, specific contracts over bloated ones.</li>
            <li><strong>Dependency Inversion</strong>: Decoupling via abstractions for testability and flexibility.</li>
        </ul>
        <p>
            <strong>Dependency Management</strong>: Deep fluency in the Composer and NPM ecosystems. Managing version constraints and security advisories is a critical part of maintaining a healthy software supply chain.
        </p>
        <p>
            <strong>Collaborative Git Workflows</strong>: PRs as a high-bandwidth communication channel. Commit messages that focus on the <em>why</em> behind a change, enabling team velocity and long-term project archeology.
        </p>
    </x-modal>

    <x-modal name="laravel-modal" title="Laravel & PHP Expertise">
        <p>
            You don't stay with a framework for over a decade unless it consistently delivers value. I am a
            <strong>Laravel veteran since v3.2</strong>, having witnessed the ecosystem’s evolution from a Rails-inspired MVC to a
            comprehensive, enterprise-ready powerhouse.
        </p>
        <p>
            My expertise goes beyond surface-level API knowledge. I understand the underlying architectural decisions of the framework, allowing me to extend, optimize, and scale Laravel applications thoughtfully. From complex Eloquent modeling to reactive Livewire components, I build with the grain of the framework to ensure maintainability and performance.
        </p>
    </x-modal>

    @fluxScripts
</body>
</html>
