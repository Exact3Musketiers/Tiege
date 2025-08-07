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

    public static function calculateTotal($stats): array
    {
        $return['distance_driven'] = $stats->sum('odo_reading');
        $return['liters_tanked'] = self::convertToFloat($stats->sum('liters_tanked'));

        $return['price'] = $stats->map(function ($item) {
            return self::convertToFloat($item->price_per_liter) * self::convertToFloat($item->liters_tanked);
        })->sum();

        $return['price'] = round($return['price'], 2);

        return $return;
    }
}
