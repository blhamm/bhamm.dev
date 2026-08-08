<?php

use App\Models\GuestBookUser;
use Livewire\Volt\Component;

new class extends Component {
    public function with()
    {
        return [
            'entries' => GuestBookUser::where('private', false)
                ->whereNotNull('lat')
                ->whereNotNull('long')
                ->latest()
                ->get()
                ->map(fn($user) => [
                    'name' => $user->name,
                    'message' => $user->message,
                    'lat' => $user->lat,
                    'lng' => $user->long,
                ]),
        ];
    }
}; ?>

<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="typing-animation text-pale-night-black dark:text-pale-night-white text-2xl font-bold md:text-4xl">
                Global Connections
            </h2>
            <p class="text-zinc-500 dark:text-zinc-400 mt-2">
                Join the network of visitors from around the globe.
            </p>
        </div>
        
        <div class="flex gap-2">
            <x-button href="{{ route('social.redirect', 'github') }}" class="bg-pale-night-black/5 dark:bg-white/5 text-pale-night-black dark:text-pale-night-white ring-pale-night-black/10 dark:ring-white/20 hover:bg-pale-night-black/10 dark:hover:bg-white/10">
                <flux:icon.github class="mr-2 size-4" />
                Sign with GitHub
            </x-button>
            <x-button href="{{ route('social.redirect', 'google') }}" class="bg-pale-night-black/5 dark:bg-white/5 text-pale-night-black dark:text-pale-night-white ring-pale-night-black/10 dark:ring-white/20 hover:bg-pale-night-black/10 dark:hover:bg-white/10">
                Sign with Google
            </x-button>
        </div>
    </div>

    <div class="glass-pane relative h-[500px] w-full overflow-hidden rounded-3xl" 
         x-data="guestbookMap(@js($entries))"
         x-init="initMap()">
        <div id="map" class="h-full w-full z-0" wire:ignore></div>
        
        {{-- Map Overlay for Legend --}}
        <div class="absolute bottom-6 left-6 z-10 flex gap-4">
             <div class="bg-pale-night-black/80 backdrop-blur-md rounded-lg px-4 py-2 text-xs text-white border border-white/10 shadow-xl">
                <span class="inline-block w-2 h-2 rounded-full bg-pale-night-blue mr-2 animate-pulse"></span>
                Public Visitor
             </div>
        </div>
    </div>

    @push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <style>
        .leaflet-container {
            background: #292D3E !important;
        }
        .leaflet-tile-pane {
            filter: brightness(0.6) invert(1) contrast(3) hue-rotate(200deg) saturate(0.3) brightness(0.7);
        }
        .dark .leaflet-tile-pane {
            filter: brightness(0.4) invert(1) contrast(3) hue-rotate(200deg) saturate(0.3) brightness(0.5);
        }
        .leaflet-popup-content-wrapper {
            background: rgba(41, 45, 62, 0.9) !important;
            color: white !important;
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .leaflet-popup-tip {
            background: rgba(41, 45, 62, 0.9) !important;
        }
    </style>
    @endpush

    @push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        function guestbookMap(entries) {
            return {
                map: null,
                initMap() {
                    this.map = L.map('map', {
                        zoomControl: false,
                        attributionControl: false,
                        scrollWheelZoom: false
                    }).setView([20, 0], 2);

                    L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
                        maxZoom: 19,
                    }).addTo(this.map);

                    const icon = L.divIcon({
                        className: 'custom-div-icon',
                        html: `<div class="w-3 h-3 bg-pale-night-blue rounded-full ring-4 ring-pale-night-blue/20 animate-pulse shadow-[0_0_10px_rgba(130,170,255,0.5)]"></div>`,
                        iconSize: [12, 12],
                        iconAnchor: [6, 6]
                    });

                    entries.forEach(entry => {
                        L.marker([entry.lat, entry.lng], { icon })
                            .addTo(this.map)
                            .bindPopup(`
                                <div class="p-2 min-w-[150px]">
                                    <div class="font-bold text-pale-night-blue text-lg">${entry.name}</div>
                                    <div class="text-white/80 text-sm mt-1 leading-relaxed italic">"${entry.message || 'Connected to the grid.'}"</div>
                                </div>
                            `);
                    });
                }
            }
        }
    </script>
    @endpush
</div>
