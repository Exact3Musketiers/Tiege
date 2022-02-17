<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

use App\Services\Steam;
use App\Models\User;


class SteamController extends Controller
{
    public function show(User $user)
    {
        if(isset($user->steamid))
        {
            if (request()->has('refresh')) {
                Cache::forget('user.'.$user->getKey().'.recentGames');
                Cache::forget('user.'.$user->getKey().'.selectedGame');
                Cache::forget('user.'.$user->getKey().'.playerSummary');
                Cache::forget('user.'.$user->getKey().'.ownedGames');
            }

            $recentGames = Cache::remember('user.'.$user->getKey().'.recentGames', 60*60, function () use($user) {
                return Steam::getRecentGames($user);
            });
            $selectedGame = Cache::remember('user.'.$user->getKey().'.selectedGame', 3600, function () use($user) {
                return Steam::selectGame($user);
            });
            $playerSummary = Cache::remember('user.'.$user->getKey().'.playerSummary', 3600, function () use($user) {
                return Steam::getPlayerSummary($user);
            });
            $ownedGames = Cache::remember('user.'.$user->getKey().'.ownedGames', 3600, function () use($user) {
                return Steam::getOwnedGames($user);
            });
        }
        return view('steam.show', compact('user', 'selectedGame', 'recentGames', 'playerSummary', 'ownedGames'));
    }
}
