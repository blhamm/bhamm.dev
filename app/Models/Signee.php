<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

/**
 * @property-read ?Location $location
 * @property-read ?string $city
 * @property-read ?string $state
 * @property-read ?string $country
 * @property-read ?float $latitude
 * @property-read ?float $longitude
 * @property-read ?string $place_id
 */
class Signee extends Authenticatable
{
    protected $guarded = ['id'];

    protected $casts = [
        'private' => 'boolean',
    ];

    /**
     * @return MorphOne<Location, $this>
     */
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

    public function getPlaceIdAttribute(): ?string
    {
        /** @var ?Location $location */
        $location = $this->location;

        return $location?->place_id;
    }

    protected static function booted(): void
    {
        static::creating(function ($signee) {
            if (empty($signee->alt_id)) {
                $signee->alt_id = (string) Str::uuid();
            }
            if (empty($signee->name)) {
                $signee->name = 'Anonymous';
            }
        });

        static::created(function ($signee) {
            $signee->syncLocationFromAttributes();
        });

        static::updated(function ($signee) {
            $signee->syncLocationFromAttributes();
        });
    }

    public function syncLocationFromAttributes(): void
    {
        $attrs = $this->getAttributes();
        $lat = $attrs['latitude'] ?? $attrs['lat'] ?? null;
        $lng = $attrs['longitude'] ?? $attrs['long'] ?? null;
        $city = $attrs['city'] ?? null;
        $state = $attrs['state'] ?? null;
        $country = $attrs['country'] ?? null;
        $placeId = $attrs['place_id'] ?? null;

        if ($lat !== null || $lng !== null || $city !== null || $state !== null || $country !== null || $placeId !== null) {
            $this->location()->updateOrCreate([], array_filter([
                'latitude' => $lat,
                'longitude' => $lng,
                'city' => $city,
                'state' => $state,
                'country' => $country,
                'place_id' => $placeId,
            ], fn ($v) => $v !== null));
        }
    }

    public function getDisplayNameAttribute(): string
    {
        if (empty($this->name) || $this->name === 'Anonymous') {
            return 'Anonymous';
        }

        $parts = explode(' ', $this->name);
        if (count($parts) === 1) {
            return $parts[0];
        }

        $firstName = $parts[0];
        $lastName = end($parts);
        $lastInitial = mb_substr($lastName, 0, 1);

        return "$firstName $lastInitial.";
    }

    public function getFirstNameAttribute(): string
    {
        if (empty($this->name) || $this->name === 'Anonymous') {
            return 'Anonymous';
        }

        return explode(' ', $this->name)[0];
    }
}
