<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Spotify;
use Illuminate\Http\Request;

class SpotifyController extends Controller
{
    public function authenticate(Request $request)
    {
        return Spotify::Authenticate();
    }

    public function callback(Request $request)
    {
        Spotify::getToken($request);
//        return redirect('home');
        return redirect('exp://10.1.1.169:8081/--/music');
    }

    public function following(Request $request)
    {
        dd(Spotify::getTop());
    }

    public function dashboard(Request $request)
    {

//        return $request->all();
        return Spotify::getTop($request->get('type'), 50,0, $request->get('time_range'))->items;
    }
}
