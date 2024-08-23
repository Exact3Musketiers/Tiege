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
            $weather = Cache::remember('weather', 900, function () {
                return self::getWeather($cached = false);
            });
        } else {
            $response = self::apiGet();

            if ($response->status() !== 200) {
                return ['error' => 'Er is iets mis gegaan met het ophalen van het weer.'];
            }

            $weather = json_decode($response->body());

            $toJas = self::toJas($weather);
            $windDirection = self::getWindDirection($weather);

            dd($weather->wind);

        }
            // Get wind
            $windSpeed = $weather->wind->speed;
            $windText = '';
            $windBft = '';
            // Wind speed
            switch ($windSpeed) {
                case $windSpeed >= 0.0 && $windSpeed <= 0.2:
                    $windText = 'windstil';
                    $windBft = 0;
                    break;
                case $windSpeed >= 0.3 && $windSpeed <= 1.5:
                    $windText = 'zwakke wind';
                    $windBft = 1;
                    break;
                case $windSpeed >= 1.6 && $windSpeed <= 3.3:
                    $windText = 'zwakke wind';
                    $windBft = 2;
                    break;
                case $windSpeed >= 3.4 && $windSpeed <= 5.4:
                    $windText = 'matige wind';
                    $windBft = 3;
                    break;
                case $windSpeed >= 5.5 && $windSpeed <= 7.9:
                    $windText = 'matige wind';
                    $windBft = 4;
                    break;
                case $windSpeed >= 8.0 && $windSpeed <= 10.7:
                    $windText = 'vrij krachtige wind';
                    $windBft = 5;
                    break;
                case $windSpeed >= 10.8 && $windSpeed <= 13.8:
                    $windText = 'krachtige wind';
                    $windBft = 6;
                    break;
                case $windSpeed >= 13.9 && $windSpeed <= 17.1:
                    $windText = 'harde wind';
                    $windBft = 7;
                    break;
                case $windSpeed >= 17.2 && $windSpeed <= 20.7:
                    $windText = 'stormachtige wind';
                    $windBft = 8;
                    break;
                case $windSpeed >= 20.8 && $windSpeed <= 24.4:
                    $windText = 'storm';
                    $windBft = 9;
                    break;
                case $windSpeed >= 24.5 && $windSpeed <= 28.4:
                    $windText = 'zware storm';
                    $windBft = 10;
                    break;
                case $windSpeed >= 28.5 && $windSpeed <= 32.6:
                    $windText = 'zeer zware storm';
                    $windBft = 11;
                    break;
                case $windSpeed >= 32.7:
                    $windText = 'orkaan';
                    $windBft = 12;
                    break;
            }

            // All data in array
            $allWeather = [
                'temperature' => $weather->main->temp,
                'temperatureMax' => $weather->main->temp_max,
                'temperatureMin' => $weather->main->temp_min,
                'temperatureFeels' => $weather->main->feels_like,
                'windText' => $windText,
                'windBft' => $windBft,
                'windDirection' => $windDirection,
                'type' => $weather->weather[0]->description,
                'toJas' => $toJas,
            ];
        // Return weather
        return $allWeather;

    }

    /**
     * @param  mixed  $weather
     * @return bool|string
     */
    public static function toJas(mixed $weather): bool|string
    {
        if (!isset($weather->weather[0])) {
            return 'Er is iets misgegaan bij het uitzoeken of je een jas moet dragen.';
        }

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
        if (!isset($weather->weather[0])) {
            return 'Er is iets misgegaan bij ophalen van de windkracht en windrichting.';
        }

        $directions = [
            'Noorden', 'Noord Noord Oosten', 'Noord Oosten', 'Oost Noord Oosten', 'Oosten', 'Oost Zuid Oosten',
            'Zuid Oosten', 'Zuid Zuid Oosten', 'Zuiden', 'Zuid Zuid Westen', 'Zuid Westen', 'West Zuid Westen',
            'Westen', 'West Noord Westen', 'Noord Westen', 'Noord Noord Westen'
        ];
        $windDeg = $weather->wind->deg;

        $degree = ($windDeg / 22.5) + 0.5;
        return $directions[$degree % 16];
    }


}
