<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class Weather
{
    public static function apiGet($location) {
        return Http::get('api.openweathermap.org/data/2.5/weather', [
            'q' => $location,
            'lang' => 'nl',
            'units' => 'metric',
            'APPID' => config('services.weather.key'),
        ]);
    }

    public static function getWeather($location, $cached = false) {
        $user_id = auth()->id();

        if (request()->has('refresh')) {
            Cache::forget('weather.' . $user_id);
        }

        if ($cached && ! request()->has('refresh')) {
            // Call openweathermap api
            $all_weather = Cache::remember('weather.' . $user_id, 900, function () use($location) {
                return self::getWeather(location: $location, cached: false);
            });
        } else {
            $response = self::apiGet($location);

            if ($response->status() !== 200) {
                return ['error' => 'Er is iets mis gegaan met het ophalen van het weer.'];
            }

            $weather = json_decode($response->body());

            if (!isset($weather->weather[0])) {
                return ['error' => 'Er is iets mis gegaan met het ophalen van het weer.'];
            }

            $bram = self::weatherManBram($weather);

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
                'wind_text' => $wind_speed['text'],
                'wind_bft' => $wind_speed['bft'],
                'wind_direction' => $wind_direction,
                'type' => $weather->weather[0]->description,
                'bram' => $bram,
                'to_jas' => $to_jas,
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
            'N', 'NNO', 'NO', 'ONO', 'O', 'OZO', 'ZO', 'ZZO', 'Z', 'ZZW', 'ZW', 'WZW', 'W', 'WNW', 'NW', 'NNW'
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

    public static function weatherManBram(mixed $weather)
    {
        $the_chosen_bram = $weather->weather[0]->main;


        $brammen = [
            'Thunderstorm' => 'images/brammen/donder_bram.png',
            'Drizzle' => 'images/brammen/vochtige_bram.png', // done
            'Rain' => 'images/brammen/natte_bram.png', // done
            'Snow' => 'images/brammen/koude_bram.png', //done
            'Atmosphere' => 'images/brammen/oh_shit_bram.png', // done
            'Clear' => 'images/brammen/gewoon_bram.png', // done
            'Clouds' => 'images/brammen/bewolkte_bram.png',
        ];

        if (array_key_exists($the_chosen_bram, $brammen)) {
            $return = $brammen[$the_chosen_bram];
        } else {
            shuffle($brammen);
            $return = end($brammen);
        }

        return $return;
    }
}
