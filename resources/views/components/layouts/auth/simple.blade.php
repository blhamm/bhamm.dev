<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
    @fluxAppearance
</head>
<body class="bg-pale-night-white dark:bg-pale-night-black text-pale-night-black dark:text-pale-night-white min-h-screen antialiased">
    <div class="flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10">
        <div class="flex w-full max-w-sm flex-col gap-2">
            <a href="{{ route('home') }}" class="flex flex-col items-center gap-2 font-medium" wire:navigate>
                <span class="mb-1 flex h-9 w-9 items-center justify-center rounded-md">
                    <x-app-logo-icon class="size-9 fill-current text-black dark:text-white" />
                </span>
                <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
            </a>
            <div class="flex flex-col gap-6">{{ $slot }}</div>
        </div>
    </div>
    @fluxScripts
</body>
</html>
