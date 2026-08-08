<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuestBookUser extends Model
{
    protected $fillable = [
        'name',
        'email',
        'lat',
        'long',
        'place_id',
        'message',
        'social_auth_type',
        'private',
    ];

    protected $casts = [
        'private' => 'boolean',
        'lat' => 'float',
        'long' => 'float',
    ];
}
