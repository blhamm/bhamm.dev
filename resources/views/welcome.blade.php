<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    @use('Illuminate\Support\Facades\Image')
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
                            @php
                                $avatar = Image::fromPath(public_path('images/me.webp'));
                            @endphp
                            <img
                                src="/images/me.webp"
                                alt="Brandon Hamm"
                                width="{{ $avatar->width() }}"
                                height="{{ $avatar->height() }}"
                                class="rounded-full"
                            />
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
            <x-scroll-scaled-image src="/images/gradial.webp" alt="Code on a screen" />

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
                            image="/images/cloud.webp"
                            :tags="['REST', 'OAuth', 'Redis', 'Event-Driven']"
                            size="w-xs md:w-xl"
                            modal="api-modal"
                        />

                        <x-project-card
                            title="Database Mastery & Data Layer"
                            description="Polyglot data strategy focusing on relational integrity and high-performance caching. From complex PostgreSQL schemas to low-latency Redis implementations, ensuring data safety and query efficiency."
                            image="/images/db.webp"
                            :tags="['PostgreSQL', 'MySQL', 'Redis', 'SQLite']"
                            size="w-xs md:w-xl"
                            modal="database-modal"
                        />

                        <x-project-card
                            title="Observability & System Reliability"
                            description="Engineering for reliability through total visibility. Implementing OpenTelemetry (OTLP) for distributed tracing and metrics. Moving beyond simple monitoring to proactive system health."
                            image="/images/observability.webp"
                            :tags="['Grafana', 'OTLP', 'Observability', 'SRE']"
                            size="w-xs md:w-xl"
                            modal="observability-modal"
                        />

                        <x-project-card
                            title="DevOps, Deployment & Infrastructure"
                            description="Infrastructure as code and container-native workflows. Streamlining delivery with GitHub Actions and Ansible. Building reproducible, self-healing environments across AWS and DigitalOcean."
                            image="/images/devops.webp"
                            :tags="['Docker', 'AWS', 'GitHub Actions', 'Tailscale']"
                            size="w-xs md:w-xl"
                            modal="devops-modal"
                        />

                        <x-project-card
                            title="Laravel & PHP Expertise"
                            description="Deep-domain expertise in the Laravel ecosystem since v3.2. Architecting high-performance PHP applications by leveraging the framework's core strengths and knowing when to extend them."
                            image="/images/php.webp"
                            :tags="['Laravel', 'PHP', 'Eloquent', 'Livewire']"
                            size="w-xs md:w-xl"
                            modal="laravel-modal"
                        />

                        <x-project-card
                            title="Engineering Standards & Craft"
                            description="Strict adherence to SOLID principles and type-safe development. Using testing (Pest/PHPUnit) as a primary design tool. Driving team velocity through clean code and strict static analysis."
                            image="/images/gradial.webp"
                            :tags="['Testing', 'SOLID', 'PHPStan', 'TypeScript']"
                            size="w-xs md:w-xl"
                            modal="engineering-modal"
                        />

                        <x-project-card
                            title="Frontend Architecture & Design Systems"
                            description="Bridging high-end design with reactive engineering. Meticulous implementation of design systems using Vue, React, and Tailwind CSS. Crafting pixel-perfect, accessible interfaces from Figma to production."
                            image="/images/front-end.webp"
                            :tags="['Vue', 'React', 'TypeScript', 'Tailwind']"
                            size="w-xs md:w-xl"
                            modal="frontend-modal"
                        />
                    </x-carousel>
                </section>

                <section id="kit" class="space-y-8">
                    <h2 class="typing-animation text-pale-night-black dark:text-pale-night-white text-2xl font-bold md:mb-6 md:text-4xl">
                        My Tool Kit
                    </h2>
                    <x-bento-grid>
                        {{-- Row 1: The Core --}}
                        <a href="https://www.apple.com/macbook-pro/" target="_blank" class="glass-pane group relative flex min-h-[350px] flex-col justify-end overflow-hidden rounded-3xl p-8 md:col-span-8 md:row-span-2 transition-all hover:ring-2 hover:ring-pale-night-blue/50">
                            <div class="absolute inset-0 z-0 overflow-hidden">
                                <div class="absolute inset-0 z-10 bg-gradient-to-t from-pale-night-black/80 to-transparent"></div>
                                <img src="/images/gradial.webp" alt="MacBook Pro" class="h-full w-full object-cover opacity-40 transition-transform duration-700 group-hover:scale-110" />
                            </div>
                            <div class="relative z-20 space-y-2">
                                <div class="flex items-center gap-3">
                                    <flux:icon.cpu-chip class="size-6 text-pale-night-blue" />
                                    <span class="text-pale-night-blue text-xs font-bold uppercase tracking-[0.2em]">Bleeding Edge</span>
                                </div>
                                <flux:heading level="3" size="xl" class="text-white">14" MacBook Pro M5</flux:heading>
                                <p class="text-white/70 max-w-md">
                                    Space Black, 128GB Unified Memory. Running the latest macOS 27 Developer Beta.
                                </p>
                            </div>
                        </a>

                        <a href="https://www.jetbrains.com/phpstorm/" target="_blank" class="glass-pane flex flex-col items-center justify-center space-y-6 rounded-3xl p-8 text-center transition-all hover:ring-2 hover:ring-pale-night-blue/50 md:col-span-4">
                            <img src="/images/kit/PhpStorm.svg" alt="PhpStorm" class="h-20 w-auto" />
                            <div>
{{--                                <flux:heading level="3" size="lg">PhpStorm</flux:heading>--}}
                                <p class="text-pale-night-black/60 dark:text-pale-night-white/60 text-sm">
                                    Material Pale Night (Lite). Deeply customized for peak velocity.
                                </p>
                            </div>
                            <div class="flex flex-wrap justify-center gap-2">
                                <x-tag>phpCompanion</x-tag>
                                <x-tag>Generative AI</x-tag>
                            </div>
                        </a>

                        {{-- Row 2 --}}
                        <a href="https://ghostty.org/" target="_blank" class="glass-pane flex flex-col justify-between rounded-3xl p-8 transition-all hover:ring-2 hover:ring-pale-night-green/50 md:col-span-2">
                            <svg width="132" height="32" viewBox="0 0 132 32" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-8 w-auto self-start">
                                <g clip-path="url(#clip0_8215_221)">
                                    <path d="M48.4947 6.59229C53.2091 6.59229 55.8629 9.29763 56.1302 13.0228H53.4506C53.1552 10.451 51.4415 9.00459 48.6283 9.00459H48.3611C44.6102 9.00459 42.0642 11.7099 42.0642 16.2392C42.0642 20.7145 44.6102 23.4737 48.3611 23.4737H48.6283C51.9244 23.4737 53.8538 21.4647 53.8538 18.9984V18.4897H48.4947V16.1055H53.9874C55.462 16.1055 56.2638 16.8815 56.2638 18.3819V25.6165H53.8515V23.4995C53.2349 24.4373 51.3595 25.8837 48.4924 25.8837C43.0535 25.8837 39.3823 21.8374 39.3823 16.2392C39.3823 10.6128 42.9457 6.59463 48.4924 6.59463L48.4947 6.59229ZM58.7816 6.86188H61.3275V14.0965C62.2113 12.7836 63.5781 11.9538 65.6153 11.9538C68.6418 11.9538 70.4376 13.8292 70.4376 16.6424V25.6188H67.8916V17.1792C67.8916 15.2241 67.0078 14.0988 65.1863 14.0988H64.9729C63.0436 14.0988 61.3299 15.625 61.3299 18.117V25.6188H58.7839V6.86188H58.7816ZM78.849 11.9514C82.4663 11.9514 85.2795 14.8185 85.2795 18.9164C85.2795 23.0166 82.4663 25.8814 78.849 25.8814C75.2317 25.8814 72.4185 23.0143 72.4185 18.9164C72.4185 14.8162 75.2317 11.9514 78.849 11.9514ZM78.9568 23.741C81.1535 23.741 82.7335 21.9734 82.7335 18.9187C82.7335 15.8641 81.1535 14.0965 78.9568 14.0965H78.7435C76.5469 14.0965 74.9668 15.8641 74.9668 18.9187C74.9668 21.9734 76.5469 23.741 78.7435 23.741H78.9568ZM89.164 21.4623C89.2976 22.9369 90.5026 23.7387 92.1389 23.7387H92.3523C93.7729 23.7387 94.8443 23.0682 94.8443 21.9968C94.8443 21.113 94.3356 20.5222 93.0228 20.2831L91.0676 19.908C88.7092 19.4532 87.1549 18.2201 87.1549 16.0774C87.1549 13.4776 89.4852 11.9514 92.2187 11.9514C95.6742 11.9514 97.5239 13.7729 97.5239 16.3728H94.9779C94.8443 15.0858 93.8784 14.0965 92.3523 14.0965H92.1389C90.6644 14.0965 89.7009 14.8466 89.7009 15.8102C89.7009 16.694 90.3174 17.2847 91.5763 17.5239L93.6932 17.9529C95.9438 18.4077 97.3902 19.615 97.3902 21.8655C97.3902 24.2779 95.2194 25.8837 92.1132 25.8837C88.6037 25.8837 86.7822 24.0622 86.6204 21.4623H89.1663H89.164ZM114.028 23.3378C113.252 23.3378 112.957 23.0424 112.957 22.2664V14.4153H116.171V12.2187H112.957V7.87932H110.411V12.2187H104.247V7.87932H101.701V12.2187H98.7546V14.4153H101.701V22.6673C101.701 24.517 102.801 25.6141 104.648 25.6141H107.862V23.3378H105.316C104.54 23.3378 104.245 23.0424 104.245 22.2664V14.4153H110.408V22.6673C110.408 24.517 111.508 25.6141 113.355 25.6141H116.569V23.3378H114.023H114.028ZM131.202 12.2187L124.8 28.4273C124.104 30.1152 123.22 30.57 121.532 30.57H118.477V28.2937H121.129C122.067 28.2937 122.416 28.0522 122.737 27.2762L123.541 25.239L117.673 12.2187H120.379L124.772 21.971L128.577 12.2187H131.202Z" fill="white"/>
                                    <path d="M20.3955 32C19.1436 32 17.9152 31.6249 16.879 30.9333C15.8428 31.6249 14.6121 32 13.3625 32C12.113 32 10.8822 31.6249 9.84606 30.9333C8.8169 31.6249 7.62598 31.9906 6.37177 32H6.33426C4.63228 32 3.0358 31.3225 1.83316 30.0941C0.64928 28.8844 -0.00244141 27.2926 -0.00244141 25.6117V13.3626C-9.70841e-05 5.99443 5.99433 0 13.3625 0C20.7307 0 26.7252 5.99443 26.7252 13.3626V25.6164C26.7252 29.0086 24.0995 31.8078 20.7472 31.9906C20.6299 31.9977 20.5127 32 20.3955 32Z" fill="#3551F3"/>
                                    <path d="M20.3955 30.5934C19.2773 30.5934 18.1848 30.209 17.3151 29.5104C17.165 29.3884 17.0033 29.365 16.8954 29.365C16.7243 29.365 16.5508 29.426 16.4078 29.5408C15.5451 30.2207 14.4644 30.5958 13.3625 30.5958C12.2607 30.5958 11.18 30.2207 10.3173 29.5408C10.1789 29.4306 10.0148 29.3744 9.84605 29.3744C9.67726 29.3744 9.51316 29.433 9.37485 29.5408C8.50979 30.223 7.46891 30.5864 6.36474 30.5958H6.33192C5.01675 30.5958 3.7766 30.0706 2.84122 29.1142C1.91756 28.1694 1.40649 26.9269 1.40649 25.6164V13.3673C1.40649 6.77043 6.7703 1.40662 13.3625 1.40662C19.9548 1.40662 25.3186 6.77043 25.3186 13.3627V25.6164C25.3186 28.2608 23.2767 30.4434 20.6698 30.5864C20.5784 30.5911 20.4869 30.5934 20.3955 30.5934Z" fill="black"/>
                                    <path d="M23.9119 13.3627V25.6165C23.9119 27.4919 22.4654 29.079 20.5923 29.1822C19.6827 29.2314 18.8435 28.936 18.1941 28.4132C17.4158 27.7873 16.321 27.8154 15.5356 28.4343C14.9378 28.9055 14.183 29.1869 13.3601 29.1869C12.5372 29.1869 11.7847 28.9055 11.1869 28.4343C10.3922 27.8084 9.29738 27.8084 8.50266 28.4343C7.90954 28.9009 7.16405 29.1822 6.35291 29.1869C4.40478 29.2009 2.81299 27.5599 2.81299 25.6118V13.3627C2.81299 7.53704 7.5368 2.81323 13.3624 2.81323C19.1881 2.81323 23.9119 7.53704 23.9119 13.3627Z" fill="white"/>
                                    <path d="M11.2808 12.4366L7.3494 10.1673C6.83833 9.87192 6.18192 10.0477 5.88654 10.5588C5.59115 11.0699 5.76698 11.7263 6.27804 12.0217L8.60361 13.365L6.27804 14.7083C5.76698 15.0036 5.59115 15.6577 5.88654 16.1711C6.18192 16.6822 6.83599 16.858 7.3494 16.5626L11.2808 14.2933C11.9935 13.8807 11.9935 12.8516 11.2808 12.4389V12.4366Z" fill="black"/>
                                    <path d="M20.1822 12.2913H15.0176C14.4269 12.2913 13.9463 12.7695 13.9463 13.3626C13.9463 13.9557 14.4245 14.434 15.0176 14.434H20.1822C20.773 14.434 21.2535 13.9557 21.2535 13.3626C21.2535 12.7695 20.7753 12.2913 20.1822 12.2913Z" fill="black"/>
                                </g>
                                <defs>
                                    <clipPath id="clip0_8215_221">
                                        <rect width="131.202" height="32" fill="white"/>
                                    </clipPath>
                                </defs>
                            </svg>
                            <div>
{{--                                <flux:heading level="4" size="md">Ghostty + Zsh</flux:heading>--}}
                                <p class="text-pale-night-black/60 dark:text-pale-night-white/60 mt-1 text-xs">
                                    The ultimate GPU-accelerated terminal experience.
                                </p>
                            </div>
                        </a>

                        <a href="https://httpie.io/" target="_blank" class="glass-pane flex flex-col justify-between rounded-3xl p-8 transition-all hover:ring-2 hover:ring-pale-night-yellow/50 md:col-span-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1635.31 470" fill="currentColor" class="h-8 w-auto self-start text-pale-night-black dark:text-pale-night-white">
                                <g data-name="Layer 2"><g data-name="Layer 1"><path d="M1322.19 73.91a36.56 36.56 0 0 1 36.56-36.29h3.41a36.56 36.56 0 0 1 36.56 36.83 36.56 36.56 0 0 1-36.56 36.29h-3.41a36.56 36.56 0 0 1-36.56-36.83Zm6.16 276.93V142.35a7.94 7.94 0 0 1 8-7.94h48.32a7.93 7.93 0 0 1 7.94 7.94v208.49a7.94 7.94 0 0 1-7.94 7.94h-48.37a8 8 0 0 1-7.95-7.94ZM1635.31 233.34c0-61.06-33.28-105.09-101.71-105.09-72.17 0-114.82 45.45-114.82 123.08 0 74.79 46.86 113.6 113.89 113.6 56.83 0 85.93-27.17 98.33-63.86a8 8 0 0 0-5.34-10.28l-40.32-11.39a8 8 0 0 0-9.54 4.73c-5.77 14.37-16.57 25.42-42.2 25.42-29.32 0-46.06-13.62-50.74-44.29a7.17 7.17 0 0 0 .81.08h143.7a8 8 0 0 0 7.94-7.94v-24.06Zm-103.58-51.6c28.59 0 43.12 15.15 45 45H1483c4.21-31.74 20.61-45 48.73-45ZM581.91 358.75h-48.35a7.93 7.93 0 0 1-7.94-7.94V76.39a7.93 7.93 0 0 1 7.94-7.94h48.35a7.93 7.93 0 0 1 7.94 7.94v84.66a6 6 0 0 0 11.22 2.77c13.45-25.56 34.68-35.33 60.42-35.69 38.66-.55 70 31.45 70 70.12v152.56a7.94 7.94 0 0 1-7.94 7.94h-47.92a7.94 7.94 0 0 1-7.94-7.94V227.1c0-23.21-10.32-40.73-37-40.73-25.79 0-40.8 15.15-40.8 40.73v123.71a7.93 7.93 0 0 1-7.98 7.94ZM1052.84 306.12a7.94 7.94 0 0 0-9.77-6.78c-6.47 1.55-13.73 3.05-20.35 3.05-19.23 0-25.79-8.52-25.79-26.52v-87.61h50.67a7.94 7.94 0 0 0 7.94-7.94v-38.1a8 8 0 0 0-7.94-7.95h-50.67V85.86a7.94 7.94 0 0 0-7.93-7.94h-47.9a7.93 7.93 0 0 0-7.94 7.94v48.41h-90.49V85.86a7.94 7.94 0 0 0-7.94-7.94h-47.89a7.93 7.93 0 0 0-7.94 7.94v48.41h-17.85a7.94 7.94 0 0 0-7.94 7.95v38.1a7.93 7.93 0 0 0 7.94 7.94h17.85v99.93c0 42.62 21.57 77.19 73.15 77.19 21.16 0 32.43-2.5 46.08-6.56a8 8 0 0 0 5.65-8.56l-5.2-44.14a7.94 7.94 0 0 0-9.77-6.78c-6.47 1.55-13.73 3.05-20.35 3.05-19.23 0-25.79-8.52-25.79-26.52v-87.61h90.49v99.93c0 42.62 21.57 77.19 73.14 77.19 21.17 0 32.44-2.5 46.09-6.56a8 8 0 0 0 5.65-8.56ZM1219.14 365.27c-28.49 0-49.51-10.92-62.87-35.86a6 6 0 0 0-11.19 2.84v82.83a7.93 7.93 0 0 1-7.94 7.94h-48.32a7.93 7.93 0 0 1-8-7.94V142.21a8 8 0 0 1 8-7.94h48.32a7.94 7.94 0 0 1 7.94 7.94v18.95c0 6.13 8.21 8.3 11.15 2.92 13.74-25.16 35.63-36 64.31-36 53.43 0 81.08 44 81.08 116.92 0 75.78-28.62 120.27-82.48 120.27Zm19.21-119.76c0-37.39-14.06-59.17-46.4-59.17-29.53 0-46.87 20.35-46.87 57.28v4.26c0 36.45 17.34 59.17 46.87 59.17 31.87 0 46.4-22.72 46.4-61.54ZM394.41 102.12C394 45.31 346.61 0 289.8 0H104.69C48.31 0 1.09 44.6 0 101a103.07 103.07 0 0 0 103 104.92h82.7a6 6 0 0 1 2.39 11.42L61.31 272.91A103.09 103.09 0 0 0 0 367.83C.43 424.65 47.79 470 104.62 470H148c57.23 0 104.88-45.9 104.79-103.13a103.1 103.1 0 0 0-64.49-95.31 5.94 5.94 0 0 1-.1-10.94l145-63.58a103.08 103.08 0 0 0 61.21-94.92Z"/></g></g>
                            </svg>
                            <div>
{{--                                <flux:heading level="4" size="md">HTTPie</flux:heading>--}}
                                <p class="text-pale-night-black/60 dark:text-pale-night-white/60 mt-1 text-xs">
                                    Architecting and testing APIs with elegance.
                                </p>
                            </div>
                        </a>

                        {{-- Row 3 --}}
                        <a href="https://www.lg.com/us/monitors/lg-27md5kl-b-5k-uhd-led-monitor" target="_blank" class="glass-pane flex items-center gap-6 rounded-3xl p-8 transition-all hover:ring-2 hover:ring-pale-night-purple/50 md:col-span-6">
                            <flux:icon.computer-desktop class="size-12 text-pale-night-purple" />
                            <div>
                                <flux:heading level="3" size="lg">LG 5K UltraFine</flux:heading>
                                <p class="text-pale-night-black/60 dark:text-pale-night-white/60">
                                    27-inch of pixel-perfect clarity paired with a Twelve South Curve Flex stand, for my MacBook.
                                </p>
                            </div>
                        </a>

                        <a href="https://www.apple.com/airpods-max/" target="_blank" class="glass-pane group relative flex flex-col justify-end overflow-hidden rounded-3xl p-6 transition-all hover:ring-2 hover:ring-white/50 md:col-span-3">
                             <div class="absolute inset-0 z-0 overflow-hidden">
                                <div class="absolute inset-0 z-10 bg-gradient-to-t from-pale-night-black/60 to-transparent"></div>
                                <img src="/images/kit/bento_1_airpod_max_midnight__4jy1tkqh9qay_xlarge_2x.webp" alt="AirPods Max" class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110" />
                             </div>
                             <div class="relative z-20">
                                <flux:heading level="4" size="sm" class="text-white">AirPods Max</flux:heading>
                                <span class="text-white/70 text-[10px] uppercase">Midnight</span>
                             </div>
                        </a>

                        <a href="https://www.apple.com/shop/product/mxk83ll/a/magic-keyboard-with-touch-id-and-numeric-keypad-for-mac-models-with-apple-silicon-usb-c-us-english-black-keys?fnode=fe58c85239c2b55071c25a9c5474fc35e7341577fbd6514d381d67dbe710ef38f04ec873ba1c335cb614d0c27c28697816142834d421e64e6376934eb9e64c7756028c552485599caa61bd7e476513a9531faa7c5ea790c99c97ee178646ea95" target="_blank" class="glass-pane flex flex-col justify-between rounded-3xl p-6 transition-all hover:ring-2 hover:ring-pale-night-blue/50 md:col-span-3">
                             <flux:icon.square-3-stack-3d class="size-8 text-pale-night-blue" />
                             <div>
                                <flux:heading level="4" size="sm">Magic Peripherals</flux:heading>
                                <span class="text-pale-night-black/40 dark:text-pale-night-white/40 text-[10px] uppercase">Touch ID Black</span>
                             </div>
                        </a>

                        {{-- Row 4 --}}
                        <a href="https://junie.jetbrains.com" target="_blank" class="glass-pane group relative overflow-hidden rounded-3xl p-8 transition-all hover:ring-2 hover:ring-pale-night-green/50 md:col-span-4 md:row-span-2">
                             <div class="relative z-10 flex h-full flex-col justify-between">
                                <svg xmlns="http://www.w3.org/2000/svg" width="197" height="73" fill="none" viewBox="0 0 197 73" class="h-8 w-auto self-start text-pale-night-black dark:text-pale-night-white">
                                    <path fill="currentColor" d="m78.5215 67.8232 2.0498-5.7119h1.9599l-3.6181 9.1231c-.2069.5345-.5203.9607-.9395 1.2793-.4192.324-.9146.4863-1.4863.4863h-1.4131v-1.6934h1.3067c.1742 0 .333-.0482.4746-.1455.1414-.0918.2557-.2247.3427-.3974l.3428-.7207-3.2099-7.9317h2.0009l2.1895 5.7119Zm-11.4434-4.4824c.2715-.4031.6139-.7268 1.0293-.9697.5227-.3024 1.1298-.4541 1.8213-.4541.7405 0 1.4051.1869 1.9932.5596.5879.3672 1.0454.8827 1.372 1.5468.3322.659.4981 1.4046.4981 2.2364 0 .8317-.1659 1.5798-.4981 2.2441-.3321.6589-.7927 1.1742-1.3808 1.5469-.5826.3672-1.2439.5517-1.9844.5517-.6914 0-1.2986-.1517-1.8213-.4541-.4158-.2431-.7577-.568-1.0293-.9716v1.2304h-1.9277V59.0654h1.9277v4.2754Zm100.6349-4.4697c.767 0 1.451.1402 2.05.4209.599.2754 1.065.6623 1.397 1.1592.332.4914.501 1.0562.506 1.6933h-2.042c0-.297-.078-.5651-.236-.8027-.153-.2376-.374-.4212-.662-.5508-.284-.1296-.613-.1943-.989-.1943-.37 0-.697.0623-.98.1865-.283.1242-.503.2997-.661.5264-.158.2268-.238.4915-.238.7939 0 .3403.112.6214.335.8428.224.216.529.3749.915.4775l1.928.4297c.555.1242 1.051.3431 1.486.6563.436.3132.774.6967 1.013 1.1504.245.4535.368.9503.368 1.4902 0 .6535-.177 1.2427-.531 1.7666-.348.5239-.841.9368-1.478 1.2392-.632.2971-1.353.4463-2.165.4463-.816 0-1.541-.1459-2.172-.4375-.632-.297-1.127-.7109-1.487-1.2402-.354-.5293-.533-1.1397-.539-1.831h2.042c0 .3509.093.6616.278.9316.185.2646.441.4728.767.624.332.1512.714.2266 1.144.2266.414 0 .776-.0671 1.087-.2022.315-.1404.557-.3322.726-.5752.174-.2484.262-.5319.262-.8506 0-.3942-.12-.7188-.359-.9726-.24-.2591-.57-.4394-.989-.542l-1.993-.4463c-.539-.1242-1.01-.329-1.413-.6152-.403-.2863-.716-.6403-.939-1.0615-.224-.4213-.335-.8941-.335-1.418 0-.6371.166-1.2068.498-1.709.332-.5022.795-.8964 1.388-1.1826.594-.2863 1.266-.4297 2.018-.4297Zm-75.3663 8.085c0 .6588-.1546 1.2505-.4649 1.7744-.3049.5239-.7275.9344-1.2666 1.2314-.5336.297-1.1383.4453-1.8134.4453h-1.9024v-1.8545h1.6738c.3375 0 .6372-.073.8985-.2187.2668-.1458.4741-.3516.6211-.6162.1469-.2646.2207-.5647.2207-.8994v-7.753h2.0332v7.8907Zm10.6063-6.0997h-6.1259v2.9727h5.5709v1.75h-5.5709v3.0381h6.2899v1.79h-8.2742V59.0654h8.1102v1.791Zm10.38.0323h-3.528v9.5185h-2.027v-9.5185h-3.545v-1.8233h9.1v1.8233Zm6.551-1.8233c.702 0 1.329.127 1.879.3809.55.2538.977.6079 1.282 1.0615.31.4482.466.9613.466 1.5391 0 .5022-.12.948-.36 1.3369-.234.3888-.563.6912-.988.9072-.15.0776-.31.1398-.477.1895.222.0606.434.1427.632.248.468.2484.833.5944 1.094 1.0371.261.4429.393.9427.393 1.499 0 .6048-.164 1.1474-.491 1.628-.321.4753-.773.8481-1.356 1.1181-.577.2646-1.236.3965-1.977.3965h-4.99V59.0654h4.893Zm10.727 0c.784 0 1.473.1435 2.067.4297.593.2862 1.051.6911 1.372 1.2149.326.5237.49 1.1287.49 1.8144 0 .6912-.166 1.3019-.498 1.8311-.327.5238-.792.932-1.396 1.2236-.2.0973-.412.1764-.634.2412l2.781 4.5869h-2.336l-2.568-4.3906h-2.096v4.3906h-2.033V59.0654h4.851Zm15.456 11.3418h-2.058l-.972-2.7217h-4.59l-.898 2.7217h-2.108l4.149-11.3418h2.197l4.28 11.3418Zm3.551 0h-2.083V59.0654h2.083v11.3418Zm10.009-3.0136v-8.3282h1.903v11.3418h-2.042l-5.407-8.3281v8.3281h-1.903V59.0654h2.033l5.416 8.3282Zm-90.1719-3.7754c-.4629 0-.8774.1139-1.2422.3408-.3592.2214-.6394.5321-.8408.9316-.1696.332-.2672.708-.294 1.128V66.5c.0267.4211.1243.8.294 1.1367.2014.3941.4816.7048.8408.9317.3648.2214.7793.332 1.2422.332.4627 0 .8707-.1107 1.2246-.332.3594-.2269.6379-.5374.834-.9317.2013-.3995.3017-.8586.3017-1.3769 0-.5184-.1003-.975-.3017-1.3692-.1961-.3996-.4746-.7102-.834-.9316-.3539-.2267-.7619-.3408-1.2246-.3408Zm47.5209 5.1855h2.786c.386 0 .726-.0681 1.02-.2031.3-.1404.531-.3346.695-.583.163-.2538.245-.5481.245-.8828 0-.3349-.084-.6324-.253-.8916-.164-.2593-.393-.4616-.687-.6075-.294-.1457-.634-.2187-1.02-.2187h-2.786v3.3867Zm23.521-7.251-1.544 4.545h3.537l-1.641-4.545-.18-.705-.172.705Zm-12.704 2.7627h2.695c.398 0 .741-.073 1.03-.2187.294-.1458.52-.3516.678-.6162.163-.2699.244-.5857.244-.9473 0-.3563-.081-.6671-.244-.9316-.158-.2647-.384-.467-.678-.6075-.289-.1458-.632-.2187-1.03-.2187h-2.695v3.54Zm-10.817-.4541h2.687c.354 0 .665-.0647.932-.1943.272-.135.482-.3244.629-.5674.152-.2429.228-.5234.228-.8418 0-.3186-.076-.5973-.228-.8349-.147-.2376-.357-.4212-.629-.5508-.273-.1351-.583-.2022-.932-.2022h-2.687v3.1914ZM95.3486 31.96c0 1.5374.2588 2.8596.7764 3.9658.5361 1.0872 1.2938 1.9218 2.2734 2.5029.9797.5625 2.1446.8438 3.4946.8438 1.46-.0001 2.744-.3284 3.853-.9844 1.128-.6562 1.997-1.5757 2.607-2.7569.628-1.1811.943-2.5311.943-4.0498V14.5791h5.379v28.7988h-5.213v-4.4736c-.848 1.505-1.966 2.6972-3.356 3.5742-1.645 1.0497-3.585 1.5742-5.822 1.5742-2.0332 0-3.8269-.44-5.3797-1.3213-1.5525-.8999-2.772-2.2032-3.6592-3.9091-.8688-1.7062-1.3037-3.7594-1.3037-6.1592v-18.084h5.4072V31.96Zm86.8294-18.0557c2.754 0 5.194.6373 7.32 1.9121 2.126 1.2562 3.781 3.0282 4.964 5.3154 1.183 2.2873 1.774 4.8937 1.774 7.8184v1.2939h-23.021c.127 1.5647.499 2.9805 1.116 4.2471.776 1.5561 1.849 2.7655 3.217 3.6279 1.368.8623 2.911 1.2939 4.63 1.294 1.553 0 2.94-.3196 4.16-.957 1.238-.6375 2.255-1.5275 3.05-2.6709h5.933c-.684 1.7059-1.654 3.1777-2.911 4.415-1.257 1.2374-2.754 2.1932-4.492 2.8682-1.738.6562-3.651.9843-5.74.9843-2.717 0-5.176-.6468-7.375-1.9404-2.2-1.2937-3.929-3.0933-5.186-5.3994-1.257-2.3061-1.886-4.9028-1.886-7.79 0-2.8124.639-5.363 1.915-7.6504 1.275-2.3059 3.013-4.1059 5.212-5.3995 2.2-1.3122 4.64-1.9686 7.32-1.9687ZM81.7676 32.1846c0 2.1374-.49 4.0594-1.4697 5.7656-.9797 1.6873-2.3289 3.0182-4.0479 3.9932-1.719.9561-3.6508 1.4345-5.7949 1.4345h-6.378v-5.3154h5.878c1.183 0 2.2467-.2621 3.1894-.7871.9427-.525 1.6729-1.2656 2.1905-2.2217.536-.9562.8037-2.0344.8037-3.2344V4.00488h5.6289V32.1846ZM137.71 13.9043c2.033 0 3.826.4498 5.379 1.3496 1.553.8812 2.764 2.1757 3.633 3.8818.887 1.7061 1.33 3.7595 1.33 6.1592v18.083h-5.379V25.998c0-1.5373-.268-2.8501-.804-3.9375-.517-1.1061-1.266-1.9404-2.246-2.5029-.98-.5812-2.145-.8721-3.494-.8721-1.46.0001-2.754.3282-3.882.9844-1.109.6562-1.978 1.5748-2.606 2.7559-.61 1.1811-.915 2.5312-.915 4.0498v16.9023h-5.379V14.5791h5.213v4.4365c.855-1.4874 1.964-2.6663 3.327-3.5361 1.645-1.05 3.586-1.5752 5.823-1.5752Zm23.618 29.4736h-5.38V14.5791h5.38v28.7988Zm20.85-24.917c-1.738.0001-3.291.421-4.658 1.2647-1.368.8249-2.44 1.9971-3.216 3.5156-.47.9297-.794 1.9427-.973 3.0381h17.334c-.176-1.0411-.472-2.0072-.89-2.8975-.721-1.5559-1.746-2.7655-3.077-3.6279-1.312-.8625-2.82-1.293-4.52-1.293Zm-20.379-7.0312h-6.294V5.52344h6.294v5.90626Z"/>
                                    <path fill="#48E054" d="M48 16.0127v2.667C48 37.3462 39.9968 47.9999 18.668 48H16V32h2.668c9.3303-.0001 13.3388-3.9935 13.3388-13.333L32 16.0127h16Z"/>
                                    <path fill="#48E054" d="M16 32H0V16l16 .0127V32Z"/>
                                    <path fill="#48E054" d="M32 16.0127H16V0h16v16.0127Z"/>
                                </svg>
                                <div>
                                    <flux:heading level="3" size="lg">Junie</flux:heading>
                                    <p class="text-pale-night-black/60 dark:text-pale-night-white/60 text-sm">
                                        My autonomous coding partner, helping me ship faster.
                                    </p>
                                </div>
                            </div>
                            <div class="absolute -right-8 -bottom-8 size-32 bg-pale-night-green/10 blur-3xl transition-transform duration-700 group-hover:scale-150"></div>
                        </a>

                        <div class="glass-pane flex flex-col items-center justify-center space-y-4 rounded-3xl p-8 text-center md:col-span-3">
                            <div class="flex gap-4">
                                 <a href="https://bear.app/" target="_blank" class="flex size-12 items-center justify-center transition-all hover:scale-110">
                                    <img src="/images/kit/bear-icon.webp" alt="Bear" class="size-10" />
                                </a>
                                <a href="https://obsidian.md/" target="_blank">
                                    <img src="https://cdn.simpleicons.org/obsidian/c792ea" alt="Obsidian" class="size-12 grayscale transition-all hover:grayscale-0" />
                                </a>
                            </div>
                            <div>
                                <flux:heading level="3" size="md">Bear & Obsidian</flux:heading>
                                <p class="text-pale-night-black/60 dark:text-pale-night-white/60 text-sm">
                                    Personal knowledge management for complex systems.
                                </p>
                            </div>
                        </div>

                        <a href="https://www.adobe.com/creativecloud.html" target="_blank" class="glass-pane flex flex-col justify-between rounded-3xl p-6 transition-all hover:ring-2 hover:ring-pale-night-purple/50 md:col-span-5">
                            <div class="flex items-center gap-4">
                                <div class="flex items-center gap-3">
                                    <img src="/images/kit/creative-cloud-64.svg" alt="Adobe CC" class="size-10" />
                                    <img src="/images/kit/creator-studio.webp" alt="Adobe CC" class="size-10" />
{{--                                    <flux:icon.swatch class="size-8 text-pale-night-blue" />--}}
                                </div>
                                <div>
                                    <flux:heading level="3" size="md">Creative Stack</flux:heading>
                                    <p class="text-pale-night-black/60 dark:text-pale-night-white/60 text-xs">
                                        Adobe CC & Apple Creator Studio for high-end design.
                                    </p>
                                </div>
                            </div>
                        </a>

                        {{-- Row 5 --}}
                        <a href="https://paktbags.com/products/everyday-22l-backpack" target="_blank" class="glass-pane flex items-center gap-6 rounded-3xl p-8 transition-all hover:ring-2 hover:ring-zinc-500/50 md:col-span-8">
                            <div class="flex items-center">
                                <img src="/images/kit/pakt-white.png" alt="Pakt" class="h-auto w-10 hidden dark:block" />
                                <img src="/images/kit/packt-black.webp" alt="Pakt" class="h-auto w-10 block dark:hidden" />
                            </div>
                            <div>
                                <flux:heading level="3" size="md">Pakt Everyday 22L Backpack</flux:heading>
                                <p class="text-pale-night-black/60 dark:text-pale-night-white/60 text-xs">
                                    The legendary, discontinued natual color carry for digital nomads.
                                </p>
                            </div>
                        </a>

                        {{-- Row 6: Humorous Jab --}}
                        <a href="https://www.apple.com/" target="_blank" class="group flex flex-col items-center justify-center gap-6 rounded-3xl border border-red-500/20 bg-red-500/5 p-8 backdrop-blur-md transition-all hover:bg-red-500/20 md:col-span-12 md:flex-row dark:bg-red-500/10">
                            <div class="relative">
                                <flux:icon.no-symbol class="size-16 text-red-500 transition-transform duration-500 group-hover:rotate-90" />
                                <div class="absolute inset-0 bg-red-500 opacity-20 blur-2xl"></div>
                            </div>
                            <div class="text-center md:text-left">
                                <flux:heading level="3" size="lg" class="font-black uppercase tracking-[0.3em] text-red-500">Microsoft Restricted Zone</flux:heading>
                                <p class="mt-1 text-sm font-medium text-red-500/80">
                                    No Microsoft software used, allowed, or even considered.
                                </p>
                            </div>
                        </a>
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
                        src="/images/brands/American_Express_logo.svg.webp"
                        alt="American Express"
                        class="h-8 w-auto opacity-50 grayscale transition-opacity hover:opacity-100 md:h-12 dark:invert"
                    />
                    <img
                        src="/images/brands/Starbucks_Coffee_Logo.svg.webp"
                        alt="Starbucks"
                        class="h-8 w-auto opacity-50 grayscale transition-opacity hover:opacity-100 md:h-12 dark:invert"
                    />
                    <img
                        src="/images/brands/Uber_logo_2018.svg.webp"
                        alt="Uber"
                        class="h-4 w-auto opacity-50 grayscale transition-opacity hover:opacity-100 md:h-6 dark:invert"
                    />
                    <img
                        src="/images/brands/Chase_logo_2007.svg.webp"
                        alt="Chase"
                        class="h-4 w-auto opacity-50 grayscale transition-opacity hover:opacity-100 md:h-6 dark:invert"
                    />
                    <img
                        src="/images/brands/United Logo_Rebrand_Large.svg"
                        alt="United Airlines"
                        class="h-4 w-auto opacity-50 grayscale transition-opacity hover:opacity-100 md:h-6 dark:invert"
                    />
                    <img
                        src="/images/brands/Emirates_Logo.svg.webp"
                        alt="Emirates"
                        class="h-8 w-auto opacity-50 grayscale transition-opacity hover:opacity-100 md:h-12 dark:invert"
                    />
                    <img
                        src="/images/brands/Marriott_hotels_logo14.svg.webp"
                        alt="Marriott"
                        class="h-8 w-auto opacity-50 grayscale transition-opacity hover:opacity-100 md:h-12 dark:invert"
                    />
                    <img
                        src="/images/brands/Lufthansa_Logo_2018.svg.webp"
                        alt="Lufthansa"
                        class="h-4 w-auto opacity-50 grayscale transition-opacity hover:opacity-100 md:h-6 dark:invert"
                    />
                    <img
                        src="/images/brands/Air_Canada_2017.svg.webp"
                        alt="Air Canada"
                        class="h-4 w-auto opacity-50 grayscale transition-opacity hover:opacity-100 md:h-6 dark:invert"
                    />
                    <img
                        src="/images/brands/Singapore_Airlines_Logo.svg.webp"
                        alt="Singapore Airlines"
                        class="h-4 w-auto opacity-50 grayscale transition-opacity hover:opacity-100 md:h-6 dark:invert"
                    />
                    <img
                        src="/images/brands/Cathay_Pacific_logo.svg.webp"
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
