<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LastfmController extends Controller
{
    public function index()
    {
        $recentTracks = '';
        $recentResponse = Http::get('https://ws.audioscrobbler.com/2.0', [
            'method' => 'user.getRecentTracks',
            'api_key' => 'ad5a8aacfd3a692dff389c55a849abe6',
            'user' => 'mrgollem',
            'limit' => 1,
            'nowplaying' => true,
            'format' => 'json'
        ]);
        $recentTracks = json_decode($recentResponse->body());
        $recentTracks = $recentTracks->recenttracks;

        return view('lastfm.index', compact('recentTracks'));
    }

    public function fetch(){

    }
}
