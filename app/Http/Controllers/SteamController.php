<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use App\Services\Steam;
use App\Models\User;


class SteamController extends Controller
{
    public function show(User $user)
    {
        if(isset($user->steamid))
        {
            dd($this->selectGame($user));
        }
        return view('steam.show', compact($user));
    }

    public function getGamesToPlay($games, $startingPlaytime, $endingPlaytime)
    {
        $selectedGames = [];
        for ($i=0; $i < count($games); $i++) {
            if ($games[$i]['playtime_forever'] >= $startingPlaytime && $games[$i]['playtime_forever'] <= $endingPlaytime) {
                $selectedGames[$i] = $games[$i];
            }
        }

        return $selectedGames;
    }

    public function selectGame($user)
    {
        $randomGame = collect($this->getGamesToPlay(Steam::getOwnedGames($user), 15, 60))->random();
        $randomGameInfo = Steam::getGameInfo($randomGame['appid']);
        $randomGameInfo[$randomGame['appid']]['data']['playtime_forever'] = $randomGame['playtime_forever'];

        return $randomGameInfo;
    }
}
