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
}
