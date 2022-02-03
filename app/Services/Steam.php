<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;
use Illuminate\Support\Arr;

// use App\Models\User;

class Steam
{
    public static function getRecentGames($user)
    {
        // Get steam response
        $steamResponse = Http::get('http://api.steampowered.com/IPlayerService/GetRecentlyPlayedGames/v0001/', [
            'key' => config('services.steam.key'),
            'steamid' => $user->steamid,
            'format' => 'json'
        ]);

        $games = [];
        if (!empty($steamResponse['response'])) {
            if ($steamResponse['response']['total_count'] > 0) {
                // select recent game data
                $games = $steamResponse['response']['games'];
                // Select unwanted data
                $unwantedData = ['playtime_windows_forever', 'playtime_mac_forever', 'playtime_linux_forever'];
                // Modify array to have correct data
                array_walk($games, function(&$game) use($unwantedData) {
                    $game = Arr::except($game, $unwantedData);
                    $game['img_icon_url'] = self::createImageURL($game, 'img_icon_url');
                    $game['img_logo_url'] = self::createImageURL($game, 'img_logo_url');
                    return $game;
                });
            }
        }

        return $games;
    }

    public static function getPlayerSummary($user)
    {
        // Get steam response
        $steamResponse = Http::get('http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/', [
            'key' => config('services.steam.key'),
            'steamids' => $user->steamid,
            'format' => 'json'
        ]);

        // Select players
        $users = $steamResponse['response']['players'];
        // Select unwanted data
        $unwantedData = ['avatarmedium', 'avatarfull', 'avatarhash', 'primaryclanid', 'personastateflags', 'loccityid', 'locstatecode', 'loccountrycode'];
        // Modify array to have correct data
        array_walk($users, function(&$user) use($unwantedData) {
            $user = Arr::except($user, $unwantedData);

            if ($user['communityvisibilitystate'] !== 3) {
                $user['lastlogoff'] = 'Privé';
                $user['realname'] = 'Privé';
                $user['timecreated'] = 'Privé';
            }
            return $user;
        });

        return $users;
    }

    public static function getOwnedGames($user)
    {
        $steamResponse = Http::get('http://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/', [
            'key' => config('services.steam.key'),
            'steamid' => $user->steamid,
            'format' => 'json'
        ]);

        $games = [];
        if (!empty($steamResponse['response'])) {
            if ($steamResponse['response']['game_count'] > 0) {
                // select recent game data
                $games = $steamResponse['response']['games'];
                // Select unwanted data
                $unwantedData = ['playtime_windows_forever', 'playtime_mac_forever', 'playtime_linux_forever'];
                array_walk($games, function(&$game) use($unwantedData) {
                    $game = Arr::except($game, $unwantedData);
                    return $game;
                });
            }
        }

        return $games;
    }

    public static function getGameInfo($gameid)
    {
        $steamResponse = Http::get('http://store.steampowered.com/api/appdetails/', [
            'appids' => $gameid,
            'format' => 'json',
        ]);

        return $steamResponse->json();
    }

    public static function minutesToHours(int $minutes)
    {
        return floor($minutes / 60).' uur '.($minutes % 60).' min ';
    }

    public static function createImageURL($game, $type)
    {
        return 'http://media.steampowered.com/steamcommunity/public/images/apps/'.$game['appid'].'/'.$game[$type].'.jpg';
    }
}
