<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Signee extends Authenticatable
{
    protected $guarded = ['id'];

    protected static function booted(): void
    {
        static::creating(function ($signee) {
            if (empty($signee->alt_id)) {
                $signee->alt_id = (string) \Illuminate\Support\Str::uuid();
            }
            if (empty($signee->name)) {
                $signee->name = 'Anonymous';
            }
        });
    }

    protected $casts = [
        'private' => 'boolean',
        'latitude' => 'float',
        'longitude' => 'float',
    ];

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

        return "{$firstName} {$lastInitial}.";
    }

    public function getFirstNameAttribute(): string
    {
        if (empty($this->name) || $this->name === 'Anonymous') {
            return 'Anonymous';
        }

        return explode(' ', $this->name)[0];
    }
}
