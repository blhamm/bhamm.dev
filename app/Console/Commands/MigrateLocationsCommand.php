<?php

namespace App\Console\Commands;

use App\Models\Signee;
use App\Models\Visitor;
use Illuminate\Console\Command;

class MigrateLocationsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'locations:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate existing location data from Signees and Visitors to Location records';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Migrating signee locations...');
        $signeeCount = 0;

        foreach (Signee::all() as $signee) {
            if (! $signee->location) {
                $lat = $signee->getAttributes()['latitude'] ?? $signee->getAttributes()['lat'] ?? null;
                $lng = $signee->getAttributes()['longitude'] ?? $signee->getAttributes()['long'] ?? null;
                $city = $signee->getAttributes()['city'] ?? null;
                $state = $signee->getAttributes()['state'] ?? null;
                $country = $signee->getAttributes()['country'] ?? null;
                $placeId = $signee->getAttributes()['place_id'] ?? null;

                if ($lat !== null || $lng !== null || $city !== null || $state !== null || $country !== null || $placeId !== null) {
                    $signee->location()->create([
                        'latitude' => $lat,
                        'longitude' => $lng,
                        'city' => $city,
                        'state' => $state,
                        'country' => $country,
                        'place_id' => $placeId,
                    ]);
                    $signeeCount++;
                }
            }
        }

        $this->info("Migrated $signeeCount signee locations.");

        $this->info('Migrating visitor locations...');
        $visitorCount = 0;

        foreach (Visitor::all() as $visitor) {
            if (! $visitor->location) {
                $lat = $visitor->getAttributes()['latitude'] ?? $visitor->getAttributes()['lat'] ?? null;
                $lng = $visitor->getAttributes()['longitude'] ?? $visitor->getAttributes()['lng'] ?? null;
                $city = $visitor->getAttributes()['city'] ?? null;
                $state = $visitor->getAttributes()['state'] ?? null;
                $country = $visitor->getAttributes()['country'] ?? null;

                if ($lat !== null || $lng !== null || $city !== null || $state !== null || $country !== null) {
                    $visitor->location()->create([
                        'latitude' => $lat,
                        'longitude' => $lng,
                        'city' => $city,
                        'state' => $state,
                        'country' => $country,
                    ]);
                    $visitorCount++;
                }
            }
        }

        $this->info("Migrated $visitorCount visitor locations.");
        $this->info('Location migration completed successfully.');

        return 0;
    }
}
