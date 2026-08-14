<?php

use App\Models\Signee;
use App\Models\Visitor;
use Illuminate\Support\Facades\Auth;
use Laravel\Pennant\Feature;
use Livewire\Attributes\On;
use Livewire\Volt\Component;

new class extends Component {
    #[On('guestbook-signed')]
    public function refreshMap()
    {
        // This will trigger a re-render
    }

    public function with(): array
    {
        $signees = collect();

        if (Feature::active('guestbook-signees')) {
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
        }

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
            <h2 class="typing-animation text-pale-night-black dark:text-pale-night-white text-2xl font-bold md:text-4xl bg-clip-text text-transparent bg-gradient-to-r from-pale-night-blue to-pale-night-green">@if(Auth::guard('signee')->check())Thanks, {{ Auth::guard('signee')->user()->first_name }}@else Say Hi Stranger @endif</h2>
            <p class="text-zinc-500 dark:text-zinc-400 mt-2 max-w-xl text-lg leading-relaxed">
                @if(Auth::guard('signee')->check())
                    I appreciate your support! If you’re enjoying this showcase, you can help me grow by starring the repository on GitHub. I’m always looking to connect with fellow developers in the PHP, Laravel, and Symfony communities!
                @else
                    I'd love for you to leave your mark on the map. This is a technical showcase of human connections, brought to life through batch geocoding and interactive mapping.
                @endif
            </p>
        </div>
        
        <div class="relative z-10 flex flex-col items-center justify-center gap-6 w-full md:w-auto">

            @if(Auth::guard('signee')->check())
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 relative z-10 w-full sm:w-auto">
                    @if(Auth::guard('signee')->user()->social_auth_type === 'github')
                        <x-button href="https://github.com/blhamm/bhamm.dev" target="_blank" class="bg-pale-night-black/5 dark:bg-white/5 text-pale-night-black dark:text-pale-night-white ring-pale-night-black/10 dark:ring-white/20 hover:bg-pale-night-black/10 dark:hover:bg-white/10 w-full sm:w-auto">
                            <flux:icon.star class="mr-2 size-4" />
                            Star on GitHub
                        </x-button>
                    @endif
                    <flux:modal.trigger name="guestbook-modal">
                        <x-button class="bg-pale-night-blue hover:bg-pale-night-blue/80 text-pale-night-black ring-pale-night-black/10 dark:ring-white/20 w-full sm:w-auto">
                            Update Message
                        </x-button>
                    </flux:modal.trigger>
                </div>
            @else
                <div class="relative z-10 w-full sm:w-auto">
                    <flux:dropdown align="center" class="w-full sm:w-auto">
                        <x-button icon-trailing="chevron-down" class="bg-pale-night-blue hover:bg-pale-night-blue/80 text-pale-night-black ring-pale-night-black/10 dark:ring-white/20 w-full sm:w-auto">
                            Sign the Guestbook
                        </x-button>

                        <flux:menu class="min-w-48">
                            @feature('auth-github')
                            <flux:menu.item href="{{ route('social.redirect', 'github') }}">
                                <x-slot name="icon"><flux:icon.github variant="micro" class="me-2" /></x-slot>
                                Sign in with GitHub
                            </flux:menu.item>
                            @endfeature

                            @feature('auth-google')
                            <flux:menu.item href="{{ route('social.redirect', 'google') }}">
                                <x-slot name="icon"><flux:icon.google variant="micro" class="me-2" /></x-slot>
                                Sign in with Google
                            </flux:menu.item>
                            @endfeature

                            @feature('auth-apple')
                            <flux:menu.item href="{{ route('social.redirect', 'apple') }}">
                                <x-slot name="icon"><flux:icon.apple variant="micro" class="me-2" /></x-slot>
                                Sign in with Apple
                            </flux:menu.item>
                            @endfeature
                        </flux:menu>
                    </flux:dropdown>
                </div>
            @endif

            <div class="flex items-center gap-2">
                <flux:modal.trigger name="privacy-modal">
                    <button class="flex items-center gap-1.5 text-xs text-zinc-500 dark:text-zinc-400 hover:text-pale-night-blue transition-colors relative z-10">
                        <flux:icon.lock-closed class="size-3" />
                        <span>Privacy Policy</span>
                    </button>
                </flux:modal.trigger>

                @if(Auth::guard('signee')->check())
                    <span class="text-zinc-500 dark:text-zinc-400 text-xs relative z-10">|</span>
                    <form method="POST" action="{{ route('signee.logout') }}" class="inline relative z-10">
                        @csrf
                        <button type="submit" class="text-xs text-zinc-500 dark:text-zinc-400 hover:text-pale-night-blue transition-colors">
                            Sign Out
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <div class="glass-pane guestbook-map-container relative isolate rounded-3xl border border-white/10" 
         style="height: 500px;"
         x-data="guestbookMap(@js($points))"
         x-effect="points = @js($points)"
         x-on:click="isActivated = true"
         x-on:click.away="isActivated = false">
        
        <div class="h-full w-full overflow-hidden rounded-3xl" 
             style="mask-image: linear-gradient(white, white); -webkit-mask-image: -webkit-radial-gradient(white, black); clip-path: inset(0 round 1.5rem); transform: translateZ(0);">
            <div x-ref="map" class="h-full w-full z-0 bg-pale-night-white dark:bg-pale-night-black" wire:ignore></div>
        </div>

        {{-- Click to Interact Overlay --}}
        <div x-show="!isActivated" 
             class="absolute inset-0 z-20 flex items-center justify-center bg-black/5 dark:bg-black/20 cursor-pointer group transition-all duration-300"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            <div class="bg-pale-night-white/90 dark:bg-pale-night-black/90 px-6 py-3 rounded-full border border-pale-night-black/10 dark:border-white/10 shadow-2xl flex items-center gap-3 transform group-hover:scale-105 transition-all duration-300">
                <flux:icon.hand-raised class="size-5 text-pale-night-blue animate-pulse" />
                <span class="text-sm font-medium text-pale-night-black dark:text-pale-night-white">Click to interact with map</span>
            </div>
        </div>

        {{-- Deactivate Button --}}
        <button x-show="isActivated" 
                x-on:click.stop="isActivated = false"
                class="absolute top-6 right-6 z-30 bg-pale-night-white/80 dark:bg-pale-night-black/80 backdrop-blur-md rounded-lg p-2 text-pale-night-black dark:text-white border border-pale-night-black/10 dark:border-white/10 shadow-xl transition-all duration-300 hover:scale-110 active:scale-95 cursor-pointer"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0">
            <flux:icon.x-mark class="size-5" />
        </button>
        
        {{-- Map Overlay for Legend --}}
        <div class="absolute bottom-6 right-6 z-30 flex flex-col sm:flex-row gap-2">
             @feature('guestbook-signees')
             <button x-on:click="toggleLayer('signee')" 
                     :class="showSignees ? 'opacity-100' : 'opacity-50 grayscale'"
                     class="bg-pale-night-white/80 dark:bg-pale-night-black/80 backdrop-blur-md rounded-lg px-4 py-2 text-xs text-pale-night-black dark:text-white border border-pale-night-black/10 dark:border-white/10 shadow-xl flex items-center transition-all duration-300 hover:scale-105 active:scale-95 cursor-pointer">
                <span class="inline-block w-2 h-2 rounded-full bg-[#82aaff] mr-2 shadow-[0_0_8px_rgba(130,170,255,0.6)]"></span>
                Signee
             </button>
             @endfeature
             <button x-on:click="toggleLayer('visitor')" 
                     :class="showVisitors ? 'opacity-100' : 'opacity-50 grayscale'"
                     class="bg-pale-night-white/80 dark:bg-pale-night-black/80 backdrop-blur-md rounded-lg px-4 py-2 text-xs text-pale-night-black dark:text-white border border-pale-night-black/10 dark:border-white/10 shadow-xl flex items-center transition-all duration-300 hover:scale-105 active:scale-95 cursor-pointer">
                <span class="inline-block w-2 h-2 rounded-full bg-[#c3e88d] mr-2 animate-pulse shadow-[0_0_8px_rgba(195,232,141,0.6)]"></span>
                Recent Visitor
             </button>
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
