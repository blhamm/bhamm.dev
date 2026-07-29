<header
    x-data="{ mobileMenuOpen: false }"
    class="sticky top-0 z-50 w-full border-b border-zinc-200 dark:border-zinc-800"
>
    <div class="bg-pale-night-white/80 dark:bg-pale-night-black/80 absolute inset-0 -z-10 backdrop-blur-md"></div>
    <div class="relative z-10 mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
        <div class="relative z-30 flex items-center gap-4">
            <a href="/" class="font-brand text-xl font-bold text-zinc-900 dark:text-white"
                >bhamm<span class="header-dev text-indigo-500">.dev</span></a>
        </div>

        <nav class="hidden items-center gap-8 text-zinc-600 md:flex dark:text-zinc-400">
            <flux:navlist variant="pills" class="flex-row items-center">
                <flux:navlist.item href="#hero">Home</flux:navlist.item>
                <flux:navlist.item href="#expertise">Expertise</flux:navlist.item>
                <flux:navlist.item href="#about">About</flux:navlist.item>
                <flux:navlist.item href="#experience">Experience</flux:navlist.item>
            </flux:navlist>
        </nav>

        <div class="relative z-30 flex items-center gap-2">
            <flux:button
                variant="ghost"
                size="sm"
                x-on:click="darkMode = ! darkMode"
                square
                aria-label="Toggle dark mode"
            >
                <flux:icon.sun class="hidden size-5 dark:block" />
                <flux:icon.moon class="block size-5 dark:hidden" />
            </flux:button>

            <flux:button
                variant="ghost"
                class="md:hidden"
                x-on:click="mobileMenuOpen = ! mobileMenuOpen"
                square
                aria-label="Toggle menu"
            >
                <flux:icon.bars-3 x-show="! mobileMenuOpen" class="size-6" />
                <flux:icon.x-mark x-show="mobileMenuOpen" class="size-6" x-cloak />
            </flux:button>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div
        x-show="mobileMenuOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4"
        @click.away="mobileMenuOpen = false"
        class="bg-pale-night-white/95 dark:bg-pale-night-darker/95 absolute top-full left-0 z-20 w-full border-b border-zinc-200 shadow-xl backdrop-blur-xl md:hidden dark:border-zinc-800"
        x-cloak
    >
        <flux:navlist variant="outline" class="space-y-6 px-6 py-12">
            <flux:navlist.item href="#hero" x-on:click="mobileMenuOpen = false" class="py-4 text-3xl font-bold">
                Home</flux:navlist.item>
            <flux:navlist.item href="#expertise" x-on:click="mobileMenuOpen = false" class="py-4 text-3xl font-bold">
                Expertise</flux:navlist.item>
            <flux:navlist.item href="#about" x-on:click="mobileMenuOpen = false" class="py-4 text-3xl font-bold">
                About</flux:navlist.item>
            <flux:navlist.item href="#experience" x-on:click="mobileMenuOpen = false" class="py-4 text-3xl font-bold">
                Experience</flux:navlist.item>
        </flux:navlist>
    </div>
</header>
