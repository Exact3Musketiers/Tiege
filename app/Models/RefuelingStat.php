<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RefuelingStat extends Model
{
    protected $fillable = [
        'car_id',
        'odo_reading',
        'liters_tanked',
        'price_per_liter',
        'usage',
        'date',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];
}
