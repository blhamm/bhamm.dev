<?php

use App\Models\Signee;
use App\Models\Visitor;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component {
    public function with(): array
    {
        $signees = Signee::where('private', false)
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->latest()
            ->get()
            ->map(fn($user) => [
                'type' => 'signee',
                'name' => $user->display_name,
                'message' => $user->message,
                'lat' => $user->latitude,
                'lng' => $user->longitude,
            ]);

        $visitors = Visitor::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->latest()
            ->limit(200) // Keep it performant
            ->get()
            ->map(fn($visitor) => [
                'type' => 'visitor',
                'lat' => $visitor->latitude,
                'lng' => $visitor->longitude,
                'city' => $visitor->city,
                'state' => $visitor->state,
            ]);

        return [
            'points' => $signees->concat($visitors),
        ];
    }
}; ?>

<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-8 relative p-4" id="guestbook-header">
        <div class="relative z-10">
            <h2 class="typing-animation text-pale-night-black dark:text-pale-night-white text-3xl font-bold md:text-5xl bg-clip-text text-transparent bg-gradient-to-r from-pale-night-blue to-pale-night-green">
                Say Hi Stranger
            </h2>
            <p class="text-zinc-500 dark:text-zinc-400 mt-2 max-w-xl text-lg leading-relaxed">
                I'd love for you to leave your mark and join the map. This is a technical showcase of human connections, brought to life through batch geocoding and interactive mapping.
            </p>
        </div>
        
        <div class="relative z-10 flex flex-col items-center justify-center gap-6">

            @if(Auth::guard('signee')->check())
                <div class="flex items-center gap-2 relative z-10">
                    @if(Auth::guard('signee')->user()->social_auth_type === 'github')
                        <x-button href="https://github.com/blhamm/bhamm.dev" target="_blank" class="bg-pale-night-black/5 dark:bg-white/5 text-pale-night-black dark:text-pale-night-white ring-pale-night-black/10 dark:ring-white/20 hover:bg-pale-night-black/10 dark:hover:bg-white/10">
                            <flux:icon.star class="mr-2 size-4" />
                            Star on GitHub
                        </x-button>
                    @endif
                    <x-button href="/?guestbook=1&user_id={{ Auth::guard('signee')->id() }}" class="bg-pale-night-blue hover:bg-pale-night-blue/80 text-pale-night-black ring-pale-night-black/10 dark:ring-white/20">
                        Update Message
                    </x-button>
                </div>
            @else
                <div class="relative z-10">
                    <flux:dropdown>
                        <x-button icon-trailing="chevron-down" class="bg-pale-night-blue hover:bg-pale-night-blue/80 text-pale-night-black ring-pale-night-black/10 dark:ring-white/20">
                            Sign the Guestbook
                        </x-button>

                        <flux:menu class="min-w-48">
                            <flux:menu.item href="{{ route('social.redirect', 'github') }}" icon="github">GitHub</flux:menu.item>
                            <flux:menu.item href="{{ route('social.redirect', 'google') }}">
                                <x-slot name="icon">
                                    <svg class="size-4" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c3.11 0 5.72-1.01 7.64-2.74l-3.57-2.77c-.98.66-2.23 1.06-3.79 1.06-2.91 0-5.38-1.97-6.26-4.62H2.18v2.87C4.09 20.41 7.76 23 12 23z" fill="#34A853"/><path d="M5.74 13.93c-.24-.72-.37-1.5-.37-2.31s.13-1.59.37-2.31V6.44H2.18C1.43 7.97 1 9.69 1 11.5s.43 3.53 1.18 5.06l3.56-2.63z" fill="#FBBC05"/><path d="M12 5.38c1.69 0 3.21.58 4.41 1.72l3.31-3.3C17.71 1.86 15.09 1 12 1 7.76 1 4.09 3.59 2.18 7.44l3.56 2.63c.88-2.65 3.35-4.69 6.26-4.69z" fill="#EA4335"/></svg>
                                </x-slot>
                                Google
                            </flux:menu.item>
                            <flux:menu.item href="{{ route('social.redirect', 'apple') }}">
                                 <x-slot name="icon">
                                    <svg class="size-4 fill-current" viewBox="0 0 170 170" xmlns="http://www.w3.org/2000/svg"><path d="m150.37 130.25c-2.45 5.66-5.35 10.87-8.71 15.66-4.58 6.53-8.33 11.05-11.22 13.56-4.48 4.12-9.28 6.23-14.42 6.35-3.69 0-8.14-1.05-13.32-3.18-5.19-2.12-9.97-3.17-14.35-3.17-4.58 0-9.49 1.05-14.7 3.17-5.22 2.13-9.41 3.24-12.58 3.36-5.25.12-10.55-2.12-15.85-6.72-3.05-2.67-6.91-7.35-11.58-14.04-7.83-11.28-12.83-22.64-15.01-34.1-1.55-8.1-1.29-15.54.76-22.32 2.02-6.73 5.4-12.27 10.12-16.63 4.71-4.36 10.46-6.55 17.27-6.55 4.04 0 8.96 1.1 14.76 3.3 5.79 2.21 9.75 3.3 11.85 3.3 2.53 0 6.28-1.21 11.26-3.63 6.46-3.13 12.01-4.46 16.66-3.99 11.51 1.15 20.3 5.72 26.37 13.72-13.7 8.28-20.45 19.4-20.27 33.37.15 10.65 3.91 19.38 11.28 26.19 3.51 3.23 7.55 5.72 12.13 7.48-.96 2.49-1.93 4.88-2.88 7.18zm-29.46-117.71c.18 10.15-3.69 19-11.6 26.54-7.59 7.32-16.41 11.41-25.59 10.46-.22-9.15 3.73-18.23 11.03-25.75 7.14-7.27 16.51-11.75 25.57-11.25.37.01.59 0 .59 0z"/></svg>
                                </x-slot>
                                Apple
                            </flux:menu.item>
                        </flux:menu>
                    </flux:dropdown>
                </div>
            @endif

            <flux:modal.trigger name="privacy-modal">
                <button class="flex items-center gap-1.5 text-xs text-zinc-500 dark:text-zinc-400 hover:text-pale-night-blue transition-colors relative z-10">
                    <flux:icon.lock-closed class="size-3" />
                    <span>Privacy Policy</span>
                </button>
            </flux:modal.trigger>
        </div>
    </div>

    <div class="glass-pane guestbook-map-container relative isolate rounded-3xl border border-white/10" 
         style="height: 500px;"
         x-data="guestbookMap(@js($points))">
        <div class="h-full w-full overflow-hidden rounded-3xl" 
             style="mask-image: linear-gradient(white, white); -webkit-mask-image: -webkit-radial-gradient(white, black); clip-path: inset(0 round 1.5rem); transform: translateZ(0);">
            <div x-ref="map" class="h-full w-full z-0 bg-pale-night-white dark:bg-pale-night-black" wire:ignore></div>
        </div>
        
        {{-- Map Overlay for Legend --}}
        <div class="absolute bottom-6 right-6 z-10 flex flex-col sm:flex-row gap-2">
             <div class="bg-pale-night-white/80 dark:bg-pale-night-black/80 backdrop-blur-md rounded-lg px-4 py-2 text-xs text-pale-night-black dark:text-white border border-pale-night-black/10 dark:border-white/10 shadow-xl flex items-center transition-colors duration-300">
                <span class="inline-block w-2 h-2 rounded-full bg-[#82aaff] mr-2 shadow-[0_0_8px_rgba(130,170,255,0.6)]"></span>
                Signee
             </div>
             <div class="bg-pale-night-white/80 dark:bg-pale-night-black/80 backdrop-blur-md rounded-lg px-4 py-2 text-xs text-pale-night-black dark:text-white border border-pale-night-black/10 dark:border-white/10 shadow-xl flex items-center transition-colors duration-300">
                <span class="inline-block w-2 h-2 rounded-full bg-[#c3e88d] mr-2 animate-pulse shadow-[0_0_8px_rgba(195,232,141,0.6)]"></span>
                Recent Visitor
             </div>
        </div>
    </div>

    @push('styles')
    <style>
        /* MapKit JS Custom Styles */
        .mk-map-view {
            background: transparent !important;
        }

        /* Force hardware-accelerated map to respect rounded corners */
        .guestbook-map-container {
            isolation: isolate;
        }

        .guestbook-map-container > div:first-child {
            /* WebKit specific hack for border-radius clipping */
            -webkit-mask-image: -webkit-radial-gradient(white, black);
            /* Firefox fix for overflow: hidden with hardware acceleration */
            mask-image: linear-gradient(white, white);
            /* Modern browsers clip path */
            clip-path: inset(0 round 1.5rem);
            /* Force composite layer */
            transform: translateZ(0);
        }
    </style>
    @endpush

</div>
