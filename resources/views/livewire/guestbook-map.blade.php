<?php

use App\Models\Signee;
use Livewire\Volt\Component;

new class extends Component {
    public function with(): array
    {
        return [
            'entries' => Signee::where('private', false)
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->latest()
                ->get()
                ->map(fn($user) => [
                    'name' => $user->name,
                    'message' => $user->message,
                    'lat' => $user->latitude,
                    'lng' => $user->longitude,
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

    <div class="glass-pane relative overflow-hidden rounded-3xl border border-white/10" 
         style="height: 500px;"
         x-data="guestbookMap(@js($entries))"
         x-init="initMap()">
        <div x-ref="map" class="h-full w-full z-0" style="background: #2d3248;" wire:ignore></div>
        
        {{-- Map Overlay for Legend --}}
        <div class="absolute bottom-6 left-6 z-10 flex gap-4">
             <div class="bg-pale-night-black/80 backdrop-blur-md rounded-lg px-4 py-2 text-xs text-white border border-white/10 shadow-xl">
                <span class="inline-block w-2 h-2 rounded-full bg-pale-night-blue mr-2 animate-pulse"></span>
                Public Visitor
             </div>
        </div>
    </div>

    @push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.css" />
    <style>
        .leaflet-container {
            background: #292D3E !important;
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
        .leaflet-tile-pane {
            opacity: 0.9;
        }
    </style>
    @endpush

    @push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.js"></script>
    <script>
        function guestbookMap(entries) {
            return {
                map: null,
                observer: null,
                visibilityObserver: null,
                refresh() {
                    if (this.map) {
                        this.map.invalidateSize({ animate: false });
                    }
                },
                initMap() {
                    const setup = () => {
                        if (this.map) return;
                        
                        const el = this.$refs.map;
                        if (!window.L || !el || el.clientHeight === 0) {
                            setTimeout(setup, 100);
                            return;
                        }

                        this.map = L.map(el, {
                            zoomControl: false,
                            attributionControl: false,
                            scrollWheelZoom: false,
                            fadeAnimation: false
                        }).setView([30, 0], 2);

                        // Using the most reliable CartoDB Dark Matter URL
                        L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
                            subdomains: 'abcd',
                            maxZoom: 20,
                            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>'
                        }).addTo(this.map);

                        const icon = L.divIcon({
                            className: 'custom-div-icon',
                            html: `<div class="w-3 h-3 bg-pale-night-blue rounded-full ring-4 ring-pale-night-blue/20 animate-pulse shadow-[0_0_10px_rgba(130,170,255,0.5)]"></div>`,
                            iconSize: [12, 12],
                            iconAnchor: [6, 6]
                        });

                        if (Array.isArray(entries)) {
                            entries.forEach(entry => {
                                if (entry.lat && entry.lng) {
                                    L.marker([entry.lat, entry.lng], { icon })
                                        .addTo(this.map)
                                        .bindPopup(`
                                            <div class="p-2 min-w-[150px]">
                                                <div class="font-bold text-pale-night-blue text-lg">${entry.name}</div>
                                                <div class="text-white/80 text-sm mt-1 leading-relaxed italic">"${entry.message || 'Connected to the grid.'}"</div>
                                            </div>
                                        `);
                                }
                            });
                        }

                        // Force refresh multiple times to handle layout settlement
                        this.refresh();
                        setTimeout(() => this.refresh(), 100);
                        setTimeout(() => this.refresh(), 500);
                        setTimeout(() => this.refresh(), 2000);

                        this.observer = new ResizeObserver(() => this.refresh());
                        this.observer.observe(el);

                        this.visibilityObserver = new IntersectionObserver((items) => {
                            if (items[0].isIntersecting) this.refresh();
                        });
                        this.visibilityObserver.observe(el);

                        if (window.ScrollTrigger) {
                            ScrollTrigger.addEventListener('refresh', () => this.refresh());
                        }
                        window.addEventListener('resize', () => this.refresh());
                    };

                    setup();

                    // Cleanup
                    return () => {
                        if (this.observer) this.observer.disconnect();
                        if (this.visibilityObserver) this.visibilityObserver.disconnect();
                        if (window.ScrollTrigger) {
                            ScrollTrigger.removeEventListener('refresh', () => this.refresh());
                        }
                        window.removeEventListener('resize', () => this.refresh());
                        if (this.map) {
                            this.map.remove();
                            this.map = null;
                        }
                    };
                }
            }
        }
    </script>
    @endpush
</div>
