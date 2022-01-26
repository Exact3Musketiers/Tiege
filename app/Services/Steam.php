<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;
use Illuminate\Support\Arr;

// use App\Models\User;

class Steam
{
    protected static function getRecentGames($user)
    {
        // Get steam response
        $steamResponse = Http::get('http://api.steampowered.com/IPlayerService/GetRecentlyPlayedGames/v0001/', [
            'key' => config('services.steam.key'),
            'steamid' => $user->steamid,
            'format' => 'json'
        ]);
        if (!empty($steamResponse['response'])) {
            if ($steamResponse['response']['total_count'] > 0) {
                // select recent game data
                $games = $steamResponse['response']['games'];
                // Select unwanted data
                $unwantedData = ['playtime_windows_forever', 'playtime_mac_forever', 'playtime_linux_forever'];
                // Modify array to have correct data
                array_walk($games, function(&$game) use($unwantedData) {
                    $game = Arr::except($game, $unwantedData);
                    $game['img_icon_url'] = 'http://media.steampowered.com/steamcommunity/public/images/apps/'.$game['appid'].'/'.$game['img_icon_url'].'.jpg';
                    $game['img_logo_url'] = 'http://media.steampowered.com/steamcommunity/public/images/apps/'.$game['appid'].'/'.$game['img_logo_url'].'.jpg';
                    return $game;
                });
            } else {
                $games = 'Er zijn geen recente games gevonden.';
            }
        } else {
            $games = 'Privé';
        }


        return $games;
    }

    protected static function getPlayerSummary($user)
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

    protected static function getOwnedGames($user, $startingPlaytime, $endingPlaytime)
    {
        $steamResponse = Http::get('http://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/', [
            'key' => config('services.steam.key'),
            'steamid' => $user->steamid,
            'format' => 'json'
        ]);

        if (!empty($steamResponse['response'])) {
            if ($steamResponse['response']['game_count'] > 0) {
                // select recent game data
                $games = $steamResponse['response']['games'];
                // Select unwanted data
                $unwantedData = ['playtime_windows_forever', 'playtime_mac_forever', 'playtime_linux_forever'];
                array_walk($games, function(&$game) use($unwantedData, $startingPlaytime, $endingPlaytime) {
                    $game = Arr::except($game, $unwantedData);
                    $game['selected_game'] = false;

                    if ($game['playtime_forever'] >= $startingPlaytime && $game['playtime_forever'] <= $endingPlaytime) {
                        $game['selected_game'] = true;
                        dump($game);
                    }
                    return $game;
                });
                die();
            } else {
                $games = 'Er zijn geen games gevonden.';
            }
        } else {
            $games = 'Privé';
        }
dd($games);
        return $games;
    }


    public static function getSteamData($user)
    {
        return self::getOwnedGames($user, 250, 300);
    }

    public static function minutesToHours(int $minutes)
    {
        return floor($minutes / 60).' uur '.($minutes % 60).' min ';
    }
}
