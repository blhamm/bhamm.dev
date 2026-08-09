<?php

namespace App\Console\Commands;

use App\Models\Signee;
use App\Models\Visitor;
use GeoIp2\Database\Reader;
use Geocodio\Geocodio;
use Illuminate\Console\Command;

class GeoIpGeocodeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'geoip:geocode';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Geocode IP addresses in batch using MaxMind and Geocodio';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!config('geoip.geocoding_enabled')) {
            $this->warn('Geocoding is disabled in config.');
            return 0;
        }

        $dbPath = config('geoip.maxmind.database_path');
        if (!file_exists($dbPath)) {
            $this->error('MaxMind database not found at ' . $dbPath . '. Run geoip:download first.');
            return 1;
        }

        $this->info('Fetching records missing coordinates...');

        $signees = Signee::whereNull('latitude')->orWhereNull('longitude')->get();
        $visitors = Visitor::whereNull('latitude')->orWhereNull('longitude')->get();

        if ($signees->isEmpty() && $visitors->isEmpty()) {
            $this->info('No records need geocoding.');
            return 0;
        }

        $recordsToGeocode = $signees->concat($visitors);
        $this->info('Processing ' . $recordsToGeocode->count() . ' records...');

        try {
            $reader = new Reader($dbPath);
            $geocodio = new Geocodio();
            $geocodio->setApiKey(config('services.geocodio.key'));

            $locationsToGeocode = []; // location query => array of records
            $ipToLocation = []; // ip => info from maxmind

            foreach ($recordsToGeocode as $record) {
                $ip = $record->ip_address;
                if (!$ip) continue;

                $locationQuery = $ip; // Default to IP if MaxMind fails

                try {
                    $lookupIp = ($ip === '127.0.0.1') ? '8.8.8.8' : $ip;
                    $recordData = $reader->city($lookupIp);
                    
                    $city = $recordData->city->name;
                    $state = $recordData->mostSpecificSubdivision->isoCode;
                    $country = $recordData->country->name;

                    if ($city && $state) {
                        $locationQuery = "$city, $state, $country";
                        $ipToLocation[$ip] = [
                            'city' => $city,
                            'state' => $state,
                            'country' => $country,
                        ];
                    }
                } catch (\Exception $e) {
                    $this->warn("MaxMind lookup failed for IP: $ip - " . $e->getMessage());
                }

                $locationsToGeocode[$locationQuery][] = $record;
            }

            if (empty($locationsToGeocode)) {
                $this->warn('No valid locations found for batch geocoding.');
                return 0;
            }

            $uniqueQueries = array_keys($locationsToGeocode);
            $this->info('Geocoding ' . count($uniqueQueries) . ' unique locations/IPs via Geocodio...');

            $chunks = array_chunk($uniqueQueries, 100);

            foreach ($chunks as $chunk) {
                try {
                    $results = $geocodio->geocode($chunk);
                    
                    if (isset($results['results'])) {
                        foreach ($results['results'] as $index => $locationResult) {
                            $query = $chunk[$index];
                            
                            if (!empty($locationResult['response']['results'])) {
                                $data = $locationResult['response']['results'][0];
                                $lat = $data['location']['lat'];
                                $lng = $data['location']['lng'];
                                $formattedAddress = $data['formatted_address'];

                                foreach ($locationsToGeocode[$query] as $record) {
                                    $updateData = [
                                        'latitude' => $lat,
                                        'longitude' => $lng,
                                    ];

                                    if ($record instanceof Signee) {
                                        $updateData['place_id'] = $formattedAddress;
                                    } else if ($record instanceof Visitor) {
                                        $ipInfo = $ipToLocation[$record->ip_address] ?? [];
                                        $updateData['city'] = $ipInfo['city'] ?? null;
                                        $updateData['state'] = $ipInfo['state'] ?? null;
                                        $updateData['country'] = $ipInfo['country'] ?? null;
                                    }

                                    $record->update($updateData);
                                }
                            }
                        }
                    }
                } catch (\Exception $e) {
                    $this->error('Geocodio batch request failed: ' . $e->getMessage());
                }
            }

            $this->info('Geocoding complete.');
            return 0;
        } catch (\Exception $e) {
            $this->error('An error occurred: ' . $e->getMessage());
            return 1;
        }
    }
}
