<footer class="bg-pale-night-white dark:bg-pale-night-darker mt-auto border-t border-zinc-200 py-12 dark:border-zinc-800">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-8">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex justify-center space-x-6 md:order-2">
                    <a href="https://github.com/blhamm" class="text-zinc-400 hover:text-zinc-500">
                        <span class="sr-only">GitHub</span>
                        <flux:icon.github class="h-6 w-6" />
                    </a>
                    <a href="https://www.linkedin.com/in/blhamm/" class="text-zinc-400 hover:text-zinc-500">
                        <span class="sr-only">LinkedIn</span>
                        <flux:icon.linkedin class="h-6 w-6" />
                    </a>
                    <a href="https://dev-null.sh/@blhamm" class="text-zinc-400 hover:text-zinc-500">
                        <span class="sr-only">dev/null</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="1.6 1.5 45 45" class="h-6 w-6" aria-hidden="true">
                            <style>
                                .ink { fill: #121417; }
                                .accent { fill: #d9480f; }
                                @media (prefers-color-scheme: dark) {
                                    .ink { fill: #ececec; }
                                    .accent { fill: #ff8a4c; }
                                }
                            </style>
                            <path class="ink" d="M2 42h10L26 6H16Z" />
                            <path class="accent" fill-rule="evenodd" clip-rule="evenodd" d="M17.81 43.5h13.22L46.19 4.5H32.97ZM22.19 40.5l12.84-33h6.78l-12.84 33Z" />
                        </svg>
                    </a>
                </div>
                <div class="mt-8 md:order-1 md:mt-0">
                    <p class="text-center md:text-left  text-zinc-400">
                        &copy; {{ date('Y') }} Brandon Hamm <br> <span>Proudly hosted on</span> <a href="https://cloud.laravel.com"><img src="/images/brands/laravel-cloud-logo.png" alt="Laravel Cloud" class="inline-block h-6 w-auto" /></a>
                    </p>
                </div>
            </div>

        </div>
    </div>
</footer>
