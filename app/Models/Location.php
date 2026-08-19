<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Location extends Model
{
    protected $fillable = [
        'latitude',
        'longitude',
        'city',
        'state',
        'country',
        'place_id',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function locationable(): MorphTo
    {
        return $this->morphTo();
    }
}
