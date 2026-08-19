<?php

namespace App\Console\Commands;

use App\Models\Signee;
use App\Models\Visitor;
use App\Services\GeocodeService;
use Illuminate\Console\Command;

class GeoIpGeocodeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'geoip:geocode {--max-mind : Use MaxMind for coordinates instead of Geocodio}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Geocode IP addresses in batch using MaxMind and Geocodio (or MaxMind only)';

    /**
     * Execute the console command.
     */
    public function handle(GeocodeService $geocodeService): int
    {
        if (! config('geoip.geocoding_enabled')) {
            $this->warn('Geocoding is disabled in config.');

            return 0;
        }

        $dbPath = config('geoip.maxmind.database_path');
        if (! file_exists($dbPath)) {
            $this->error('MaxMind database not found at '.$dbPath.'. Run geoip:download first.');

            return 1;
        }

        $this->info('Fetching records missing coordinates...');

        $signees = Signee::where(function ($query) {
            $query->whereDoesntHave('location')
                ->orWhereHas('location', function ($q) {
                    $q->whereNull('latitude')->orWhereNull('longitude');
                });
        })->get();

        $visitors = Visitor::where(function ($query) {
            $query->whereDoesntHave('location')
                ->orWhereHas('location', function ($q) {
                    $q->whereNull('latitude')->orWhereNull('longitude');
                });
        })->get();

        if ($signees->isEmpty() && $visitors->isEmpty()) {
            $this->info('No records need geocoding.');

            return 0;
        }

        $recordsToGeocode = $signees->concat($visitors);
        $this->info('Processing '.$recordsToGeocode->count().' records...');

        try {
            $geocodioService = $geocodeService->geocodio();

            $locationsToGeocode = []; // location query => array of records
            $ipToLocation = []; // ip => info from maxmind

            foreach ($recordsToGeocode as $record) {
                $ip = $record->ip_address;
                if (! $ip) {
                    continue;
                }

                $locationQuery = $ip; // Default to IP if MaxMind fails

                $location = $geocodeService->lookup($ip);
                $city = $location['city'];
                $state = $location['state'];
                $country = $location['country'];
                $lat = $location['latitude'];
                $lng = $location['longitude'];

                if ($this->option('max-mind') && $lat && $lng) {
                    $updateData = [
                        'latitude' => $lat,
                        'longitude' => $lng,
                        'city' => $city,
                        'state' => $state,
                        'country' => $country,
                    ];

                    $record->location()->updateOrCreate([], $updateData);
                    $this->info("Geocoded $ip via MaxMind.");

                    continue;
                }

                if ($city && $state) {
                    $locationQuery = "$city, $state, $country";
                    $ipToLocation[$ip] = [
                        'city' => $city,
                        'state' => $state,
                        'country' => $country,
                    ];
                }

                $locationsToGeocode[$locationQuery][] = $record;
            }

            if (empty($locationsToGeocode)) {
                $this->warn('No valid locations found for batch geocoding.');

                return 0;
            }

            $uniqueQueries = array_keys($locationsToGeocode);
            $this->info('Geocoding '.count($uniqueQueries).' unique locations/IPs via Geocodio...');

            $chunks = array_chunk($uniqueQueries, 100);

            foreach ($chunks as $chunk) {
                try {
                    /** @var array<string, mixed> $results */
                    $results = $geocodioService->batchGeocode($chunk);

                    if (isset($results['results']) && is_array($results['results'])) {
                        foreach ($results['results'] as $index => $locationResult) {
                            if (! is_array($locationResult)) {
                                continue;
                            }
                            $query = $chunk[$index] ?? null;
                            if ($query === null) {
                                continue;
                            }

                            if (! empty($locationResult['response']['results'])) {
                                $data = $locationResult['response']['results'][0];
                                $lat = $data['location']['lat'];
                                $lng = $data['location']['lng'];
                                $formattedAddress = $data['formatted_address'];

                                foreach ($locationsToGeocode[$query] as $record) {
                                    $ip = $record->ip_address;
                                    $ipInfo = (is_string($ip) && isset($ipToLocation[$ip])) ? $ipToLocation[$ip] : [];
                                    $updateData = [
                                        'latitude' => $lat,
                                        'longitude' => $lng,
                                        'city' => $ipInfo['city'] ?? $record->city,
                                        'state' => $ipInfo['state'] ?? $record->state,
                                        'country' => $ipInfo['country'] ?? $record->country,
                                    ];

                                    if ($record instanceof Signee) {
                                        $updateData['place_id'] = $formattedAddress;
                                    }

                                    $record->location()->updateOrCreate([], $updateData);
                                }
                            }
                        }
                    }
                } catch (\Exception $e) {
                    $this->error('Geocodio batch request failed: '.$e->getMessage());
                }
            }

            $this->info('Geocoding complete.');

            return 0;
        } catch (\Exception $e) {
            $this->error('An error occurred: '.$e->getMessage());

            return 1;
        }
    }
}
