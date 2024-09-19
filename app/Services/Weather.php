<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class Weather
{
    public static function apiGet() {
        return Http::get('api.openweathermap.org/data/2.5/weather', [
            'q' => 'sneek,nl',
            'lang' => 'nl',
            'units' => 'metric',
            'APPID' => config('services.weather.key'),
        ]);
    }

    public static function getWeather($cached = false) {
        if (request()->has('refresh')) {
            Cache::forget('weather');
        }

        if ($cached && ! request()->has('refresh')) {
            // Call openweathermap api
            $all_weather = Cache::remember('weather', 900, function () {
                return self::getWeather($cached = false);
            });
        } else {
            $response = self::apiGet();

            if ($response->status() !== 200) {
                return ['error' => 'Er is iets mis gegaan met het ophalen van het weer.'];
            }

            $weather = json_decode($response->body());

            if (!isset($weather->weather[0])) {
                return ['error' => 'Er is iets mis gegaan met het ophalen van het weer.'];
            }

            $to_jas = self::toJas($weather);
            $wind_direction = self::getWindDirection($weather);

            // Get wind
            $wind_speed = self::getWindSpeed($weather);

            // All data in array
            $all_weather = [
                'temperature' => round($weather->main->temp),
                'temperatureMax' => round($weather->main->temp_max),
                'temperatureMin' => round($weather->main->temp_min),
                'temperatureFeels' => round($weather->main->feels_like),
                'windText' => $wind_speed['text'],
                'windBft' => $wind_speed['bft'],
                'windDirection' => $wind_direction,
                'type' => $weather->weather[0]->description,
                'toJas' => $to_jas,
            ];
        }
        // Return weather
        return $all_weather;
    }

    /**
     * @param  mixed  $weather
     * @return bool|string
     */
    public static function toJas(mixed $weather): bool
    {
        // Get temperature
        $temperatureFeels = $weather->main->temp;
        $main = $weather->weather[0]->main;

        // To Jas Or Not To Jas
        $toJas = true;

        if ($temperatureFeels >= 15 && $main !== 'Rain') {
            $toJas = false;
        }

        return $toJas;
    }

    /**
     * @param  mixed  $weather
     * @return string
     */
    public static function getWindDirection(mixed $weather): string
    {
        $directions = [
            'Noorden', 'Noord Noord Oosten', 'Noord Oosten', 'Oost Noord Oosten', 'Oosten', 'Oost Zuid Oosten',
            'Zuid Oosten', 'Zuid Zuid Oosten', 'Zuiden', 'Zuid Zuid Westen', 'Zuid Westen', 'West Zuid Westen',
            'Westen', 'West Noord Westen', 'Noord Westen', 'Noord Noord Westen'
        ];

        $windDeg = $weather->wind->deg;
        $degree = ($windDeg / 22.5) + 0.5;

        return $directions[$degree % 16];
    }

    public static function getWindSpeed(mixed $weather): array
    {
        $bft_names = [
            'windstil', 'zwakke wind', 'zwakke wind', 'matige wind', 'matige wind', 'vrij krachtige wind',
            'krachtige wind', 'harde wind', 'stormachtige wind', 'storm', 'zware storm', 'zeer zware storm', 'orkaan'
        ];

        $ms = $weather->wind->speed;
        $bft = round(pow(pow($ms/0.836, 2), 1/3));

        if ($bft > 12)
            $bft = 12;

        return ['bft' => $bft, 'text' => $bft_names[$bft]];
    }
}
