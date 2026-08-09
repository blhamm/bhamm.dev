<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Signee extends Authenticatable
{
    protected $fillable = [
        'name',
        'email',
        'latitude',
        'longitude',
        'ip_address',
        'place_id',
        'message',
        'social_auth_type',
        'private',
    ];

    protected $casts = [
        'private' => 'boolean',
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function getDisplayNameAttribute(): string
    {
        if (empty($this->name)) {
            return 'Anonymous';
        }

        $parts = explode(' ', $this->name);
        if (count($parts) === 1) {
            return $parts[0];
        }

        $firstName = $parts[0];
        $lastName = end($parts);
        $lastInitial = mb_substr($lastName, 0, 1);

        return "{$firstName} {$lastInitial}.";
    }
}
