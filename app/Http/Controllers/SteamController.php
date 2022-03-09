<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;

use App\Services\Steam;
use App\Models\User;


class SteamController extends Controller
{
    public function show(Request $request, User $user)
    {
        if(isset($user->steamid))
        {
            if (request()->has('refresh')) {
                Cache::forget('user.'.$user->getKey().'.recentGames');
                cache::forget('user.'.$user->getKey().'.selectedGame');
                cache::forget('user.'.$user->getKey().'.selectedGameInfo');
                Cache::forget('user.'.$user->getKey().'.playerSummary');
                Cache::forget('user.'.$user->getKey().'.ownedGames');
                Cache::forget('user.'.$user->getKey().'.percentagePlayed');
            }

            $recentGames = Cache::remember('user.'.$user->getKey().'.recentGames', 3600, function () use($user) {
                return collect(Steam::getRecentGames($user));
            });
            $playerSummary = Cache::remember('user.'.$user->getKey().'.playerSummary', 3600, function () use($user) {
                return collect(Steam::getPlayerSummary($user)[0]);
            });
            $ownedGames = Cache::remember('user.'.$user->getKey().'.ownedGames', 3600, function () use($user) {
                return collect(Steam::getOwnedGames($user));
            });
            $selectedGame = Cache::remember('user.'.$user->getKey().'.selectedGame', 3600, function () use($user, $ownedGames) {
                return Steam::selectGame($user, $ownedGames, 0, 60);
            });
            $selectedGameInfo = [];
            $percentagePlayed = 0;
            if (!empty($selectedGame)) {
                $selectedGameInfo = Cache::remember('user.'.$user->getKey().'.selectedGameInfo', 3600, function () use($selectedGame) {
                    return Steam::getGameInfo($selectedGame);
                });
                $percentagePlayed = Cache::remember('user.'.$user->getKey().'.percentagePlayed', 3600, function () use($ownedGames) {
                    return Steam::calculatePercentage($ownedGames);
                });
            }

            // dd($selectedGameInfo);

            // if (is_null($request->cookie('selectedGame'))) {
            //     $selectedGame = Cookie::forever('selectedGame', Steam::selectGame($user, $ownedGames));
            // }

            // dd($request->cookie('selectedGame'));
        }
        return view('steam.show', compact('user', 'selectedGameInfo', 'recentGames', 'playerSummary', 'ownedGames', 'percentagePlayed'));
    }

    public function getNewGame(Request $request, User $user)
    {
        $validated = $request->validate([
            'min' => ['lte:max'],
            'max' => ['gte:min']
        ]);

        $ownedGames = Cache::remember('user.'.$user->getKey().'.ownedGames', 3600, function () use($user) {
            return collect(Steam::getOwnedGames($user));
        });

        cache::forget('user.'.$user->getKey().'.selectedGame');
        cache::forget('user.'.$user->getKey().'.selectedGameInfo');
        cache::forget('user.'.$user->getKey().'.minutes');

        $min = $request->min;
        $max = $request->max;

        Cache::remember('user.'.$user->getKey().'.minutes', 3600, function () use($min, $max) {
            return ['min' => $min, 'max' => $max];
        });

        $selectedGameInfo = [];

        $selectedGame = Cache::remember('user.'.$user->getKey().'.selectedGame', 3600, function () use($user, $ownedGames, $validated) {
            return Steam::selectGame($user, $ownedGames, $validated['min'], $validated['max']);
        });
        if (!empty($selectedGame)) {
            $selectedGameInfo = Cache::remember('user.'.$user->getKey().'.selectedGameInfo', 3600, function () use($selectedGame) {
                return Steam::getGameInfo($selectedGame);
            });
        }

        return back();
    }
}
