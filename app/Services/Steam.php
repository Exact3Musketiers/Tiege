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
                    $game['img_logo_url'] = 'https://cdn.cloudflare.steamstatic.com/steam/apps/'.$game['appid'].'/header.jpg';
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
        $users[0] = null;
        if(array_key_exists(0, $steamResponse->json()['response']['players']))
        {
            // Select players
            $users = $steamResponse['response']['players'];
            // Select unwanted data
            $unwantedData = ['avatarmedium', 'avatar', 'avatarhash', 'primaryclanid', 'personastateflags', 'loccityid', 'locstatecode', 'loccountrycode'];
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
        }
// dd($users);
        return $users;
    }

    public static function getOwnedGames($user)
    {
        $steamResponse = Http::get('http://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/', [
            'key' => config('services.steam.key'),
            'steamid' => $user->steamid,
            'format' => 'json',
            'include_appinfo' => true,
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

    public static function getGameInfo($game)
    {
        $steamResponse = Http::get('http://store.steampowered.com/api/appdetails/', [
            'appids' => $game['appid'],
            'format' => 'json',
        ]);

        $info = [];

        if ($steamResponse[$game['appid']]['success']) {
            $info = $steamResponse[$game['appid']]['data'];
            $info['playtime_forever'] = self::minutesToHours($game['playtime_forever']);
        }

        return $info;
    }

    public static function minutesToHours(int $minutes)
    {
        return floor($minutes / 60).' uur '.($minutes % 60).' min ';
    }

    public static function calculatePercentage($games)
    {
        return round(count($games->where('playtime_forever', '>', 0)) / count($games) * 100, 0);
    }

    public static function createImageURL($game, $type)
    {
        $image = '';
        if (array_key_exists($type, $game)) {
            $image = 'http://media.steampowered.com/steamcommunity/public/images/apps/'.$game['appid'].'/'.$game[$type].'.jpg';
        }
        return $image;
    }

    public static function getGamesToPlay($games, $played = true)
    {
        $selectedGames = collect($games);

        if (!$played) {
            $selectedGames = $selectedGames->where('playtime_forever', 0);
        }
        return $selectedGames;
    }

    public static function selectGame($ownedGames, $played = true)
    {
        $game = collect(self::getGamesToPlay($ownedGames, $played))->random();

        // When the game has no image, it usualy means the game is unlisted and does not have any info beyond a name and a playtime.
        // This makes sure a game is returned which can be shown on the show page.
        if ($game['img_icon_url'] === '') {
            return self::selectGame($ownedGames, $played = true);
        }

        return $game;
    }
}
