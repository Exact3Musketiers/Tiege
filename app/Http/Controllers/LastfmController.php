<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class LastfmController extends Controller
{
    public function index()
    {
        $from = strtotime('-2weeks friday Friday +18 hours');
        $to = strtotime('-1weeks friday Friday +18 hours');
        $fromDate = date('d.m.y', $from);
        $toDate = date('d.m.y', $to);
        $countWeeklyTracks = $this->getWeeklyTrackChart($from, $to, null);
        $weeklyTracks = $this->getWeeklyTrackChart($from, $to, 10);
        $topAlbums = $this->getTopAlbums($from, $to);
        $weeklyArtists = $this->getWeeklyArtist($from, $to);

        return view('lastfm.index', compact('fromDate', 'toDate', 'countWeeklyTracks', 'weeklyTracks', 'topAlbums', 'weeklyArtists'));
    }

    public function getTopAlbums($from, $to)
    {
        $recentResponse = Http::get('https://ws.audioscrobbler.com/2.0', [
            'method' => 'user.getTopAlbums',
            'api_key' => 'ad5a8aacfd3a692dff389c55a849abe6',
            'user' => Auth::user()->lastfm,
            'limit' => 10,
            'from' => $from,
            'to' => $to,
            'nowplaying' => true,
            'format' => 'json',
            'period' => '7day' //overall,7day,1month,3month,6month,12month
        ]);

//        dd(json_decode($recentResponse->body()));
        return json_decode($recentResponse->body())->topalbums;
    }

    public function getWeeklyTrackChart($from, $to, $limit)
    {
        $recentResponse = Http::get('https://ws.audioscrobbler.com/2.0', [
            'method' => 'user.getWeeklyTrackChart',
            'api_key' => 'ad5a8aacfd3a692dff389c55a849abe6',
            'user' => Auth::user()->lastfm,
            'limit' => $limit,
            'from' => $from,
            'to' => $to,
            'format' => 'json',
        ]);
//        dd($from, date('d.m.y H:i:s', $from), $to, date('d.m.y H:i:s', $to), json_decode($recentResponse->body()));

        return json_decode($recentResponse->body())->weeklytrackchart;
    }

    public function getWeeklyArtist($from, $to)
    {
        $recentResponse = Http::get('https://ws.audioscrobbler.com/2.0', [
            'method' => 'user.getweeklyartistchart',
            'api_key' => 'ad5a8aacfd3a692dff389c55a849abe6',
            'user' => Auth::user()->lastfm,
            'limit' => 10,
            'from' => $from,
            'to' => $to,
            'nowplaying' => true,
            'format' => 'json'
        ]);

        return json_decode($recentResponse->body())->weeklyartistchart;
    }


    public function getRecentTracks()
    {
        $recentResponse = Http::get('https://ws.audioscrobbler.com/2.0', [
            'method' => 'user.getRecentTracks',
            'api_key' => 'ad5a8aacfd3a692dff389c55a849abe6',
            'user' => Auth::user()->lastfm,
            'limit' => 1,
            'nowplaying' => true,
            'format' => 'json'
        ]);
        return json_decode($recentResponse->body())->recenttracks;
    }

    public function getFriendsLastfmInfo()
    {
        $users = User::pluck('lastfm');
        $friendFeed = array();
//        $users = array_unique($users);
        foreach ($users as $user) {
            if (isset($user)) {
                $recentResponse = Http::get('https://ws.audioscrobbler.com/2.0', [
                    'method' => 'user.getRecentTracks',
                    'api_key' => 'ad5a8aacfd3a692dff389c55a849abe6',
                    'user' => $user,
                    'limit' => 1,
                    'nowplaying' => true,
                    'format' => 'json'
                ]);
                $recentTracks = json_decode($recentResponse->body())->recenttracks;

                $friendFeed = [
                    $user => array(
                        'user' => $user,
                        'artist' => $recentTracks->track[0]->artist->{'#text'},
                        'song' => $recentTracks->track[0]->name
                    )
                ];
            }
        }
//        dd($friendFeed);
        return $friendFeed;
    }
}
