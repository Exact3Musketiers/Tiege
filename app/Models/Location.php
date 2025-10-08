<?php

namespace App\Models;

use App\Traits\SharedResource;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use SharedResource;

    protected $fillable = [
        'name',
        'lat',
        'lon',
        'panorama_url',
        'thumbnail_url',
    ];
}
