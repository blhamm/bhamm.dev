<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Signee extends Authenticatable
{
    protected $guarded = ['id'];

    protected static function booted(): void
    {
        static::saving(function ($signee) {
            if (empty($signee->alt_id) || !\Illuminate\Support\Str::isUuid($signee->alt_id)) {
                $signee->alt_id = (string) \Illuminate\Support\Str::uuid();
            }
            if (empty($signee->name)) {
                $signee->name = 'GuestBook Signee';
            }
        });
    }

    protected $casts = [
        'private' => 'boolean',
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function setNameAttribute($value): void
    {
        $this->attributes['name'] = !empty($value) ? $value : 'GuestBook Signee';
    }

    public function getDisplayNameAttribute(): string
    {
        if (empty($this->name)) {
            return 'GuestBook Signee';
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
        if (empty($this->name)) {
            return 'Stranger';
        }

        return explode(' ', $this->name)[0];
    }
}
