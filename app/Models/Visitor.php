<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @property-read ?Location $location
 * @property-read ?string $city
 * @property-read ?string $state
 * @property-read ?string $country
 * @property-read ?float $latitude
 * @property-read ?float $longitude
 */
class Visitor extends Model
{
    protected $fillable = [
        'ip_address',
        'last_seen_at',
    ];

    protected $casts = [
        'last_seen_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::created(function ($visitor) {
            $visitor->syncLocationFromAttributes();
        });

        static::updated(function ($visitor) {
            $visitor->syncLocationFromAttributes();
        });
    }

    public function syncLocationFromAttributes(): void
    {
        $attrs = $this->getAttributes();
        $lat = $attrs['latitude'] ?? $attrs['lat'] ?? null;
        $lng = $attrs['longitude'] ?? $attrs['lng'] ?? null;
        $city = $attrs['city'] ?? null;
        $state = $attrs['state'] ?? null;
        $country = $attrs['country'] ?? null;

        if ($lat !== null || $lng !== null || $city !== null || $state !== null || $country !== null) {
            $this->location()->updateOrCreate([], array_filter([
                'latitude' => $lat,
                'longitude' => $lng,
                'city' => $city,
                'state' => $state,
                'country' => $country,
            ], fn ($v) => $v !== null));
        }
    }

    public function location(): MorphOne
    {
        return $this->morphOne(Location::class, 'locationable');
    }

    public function getCityAttribute(): ?string
    {
        /** @var ?Location $location */
        $location = $this->location;

        return $location?->city;
    }

    public function getStateAttribute(): ?string
    {
        /** @var ?Location $location */
        $location = $this->location;

        return $location?->state;
    }

    public function getCountryAttribute(): ?string
    {
        /** @var ?Location $location */
        $location = $this->location;

        return $location?->country;
    }

    public function getLatitudeAttribute(): ?float
    {
        /** @var ?Location $location */
        $location = $this->location;

        return $location?->latitude;
    }

    public function getLongitudeAttribute(): ?float
    {
        /** @var ?Location $location */
        $location = $this->location;

        return $location?->longitude;
    }
}
