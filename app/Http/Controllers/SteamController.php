<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Arr;

use App\Services\Steam;
use App\Models\User;
use App\Models\SteamReview;


class SteamController extends Controller
{
    public function index()
    {
        $users = User::whereNotNull('steamid')->get();
        return view('steam.index', compact('users'));
    }



    public function show(Request $request, User $user)
    {
        $selectedGameInfo = [];
        $recentGames = [];
        $playerSummary = [];
        $ownedGames = [];
        $percentagePlayed = 0;
        $steamReview = new SteamReview;

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
            $playerSummary = Cache::remember('user.'.$user->getKey().'.playerSummary', 86500, function () use($user) {
                return collect(Steam::getPlayerSummary($user)[0]);
            });
            $ownedGames = Cache::remember('user.'.$user->getKey().'.ownedGames', 3600, function () use($user) {
                return collect(Steam::getOwnedGames($user));
            });
            $selectedGame = Cache::remember('user.'.$user->getKey().'.selectedGame', 86500, function () use($user, $ownedGames) {
                return Steam::selectGame($user, $ownedGames, 0, 60);
            });


            if (!empty($selectedGame)) {
                $selectedGameInfo = Cache::remember('user.'.$user->getKey().'.selectedGameInfo', 86500, function () use($selectedGame) {
                    return Steam::getGameInfo($selectedGame);
                });
                $percentagePlayed = Cache::remember('user.'.$user->getKey().'.percentagePlayed', 3600, function () use($ownedGames) {
                    return Steam::calculatePercentage($ownedGames);
                });
            }

            $steamReview = new SteamReview;
            if (array_key_exists('appid', cache('user.'.$user->getKey().'.selectedGame'))) {
                $steamReview = SteamReview::whereSteamAppid(cache('user.'.$user->getKey().'.selectedGame')['appid'])->first();
            }
        }
        return view('steam.show', compact('user', 'selectedGameInfo', 'recentGames', 'playerSummary', 'ownedGames', 'percentagePlayed', 'steamReview'));
    }

    public function getNewGame(Request $request, User $user)
    {
        $validated = $request->validate([
            'min' => ['lte:max'],
            'max' => ['gte:min']
        ]);

        $ownedGames = Cache::remember('user.'.$user->getKey().'.ownedGames', 86500, function () use($user) {
            return collect(Steam::getOwnedGames($user));
        });

        cache::forget('user.'.$user->getKey().'.selectedGame');
        cache::forget('user.'.$user->getKey().'.selectedGameInfo');
        cache::forget('user.'.$user->getKey().'.minutes');

        $min = $request->min;
        $max = $request->max;

        Cache::remember('user.'.$user->getKey().'.minutes', 86500, function () use($min, $max) {
            return ['min' => $min, 'max' => $max];
        });

        $selectedGameInfo = [];

        $selectedGame = Cache::remember('user.'.$user->getKey().'.selectedGame', 86500, function () use($user, $ownedGames, $validated) {
            return Steam::selectGame($user, $ownedGames, $validated['min'], $validated['max']);
        });
        if (!empty($selectedGame)) {
            $selectedGameInfo = Cache::remember('user.'.$user->getKey().'.selectedGameInfo', 86500, function () use($selectedGame) {
                return Steam::getGameInfo($selectedGame);
            });
        }

        return back();
    }
}
