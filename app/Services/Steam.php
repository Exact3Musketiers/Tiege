<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;

// use App\Models\User;

class Steam
{
    protected static function getRecentGames($user)
    {
        $steamResponse = Http::get('http://api.steampowered.com/IPlayerService/GetRecentlyPlayedGames/v0001/', [
            'key' => config('services.steam.key'),
            'steamid' => $user->steamid,
            'format' => 'json'
        ]);

        return $steamResponse->json();
    }

    protected static function getPlayerSummary($user)
    {

        $steamResponse = Http::get('http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/', [
            'key' => config('services.steam.key'),
            'steamids' => $user->steamid,
            'format' => 'json'
        ]);

        return $steamResponse->json();
    }

    protected static function getOwnedGames($user)
    {

        $steamResponse = Http::get('http://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/', [
            'key' => config('services.steam.key'),
            'steamid' => $user->steamid,
            'format' => 'json'
        ]);

        return $steamResponse->json();
    }

    public static function getSteamData($user)
    {
        return self::getRecentGames($user);
    }
}
