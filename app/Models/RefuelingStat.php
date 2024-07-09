<?php

namespace App\Models;

use App\Traits\SharedResource;
use Illuminate\Database\Eloquent\Model;

class RefuelingStat extends Model
{
    use SharedResource;

    protected $baseRoute = 'efficiency';

    protected $fillable = [
        'car_id',
        'odo_reading',
        'liters_tanked',
        'price_per_liter',
        'usage',
        'record_date',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    public static function convertToInt($value): int
    {
        $return = $value * 1000;
        return (int) $return;
    }
    public static function convertToFloat($value): float
    {
        $return = $value / 1000;
        return (float) $return;
    }
}
