<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $fillable = [
        'ip_address',
        'latitude',
        'longitude',
        'city',
        'state',
        'country',
        'last_seen_at',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'last_seen_at' => 'datetime',
    ];
}
