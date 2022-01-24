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
            dd(Steam::getSteamData($user));
        }
        return view('steam.show', compact($user));
    }
}
