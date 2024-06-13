<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Spotify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

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
//        127.0.0.1:4040
        return redirect('exp://192.168.50.166:8081/--/music');
    }

    public function following(Request $request)
    {
        dd(auth()->user()->spotify_access_token);
        dd(Spotify::getTop());
        dd(Spotify::getTop()->items);
    }

    public function dashboard(Request $request)
    {

//        return $request->all();
//        return Spotify::getTop($request->get('type'), 50,0, $request->get('time_range'));
        return Spotify::getTop($request->get('type'), 50,0, $request->get('time_range'))->items;
    }
}
