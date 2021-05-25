<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

class LastfmController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->query('user');
        if (empty($user))
            $user = Auth::user()->lastfm;
        $from = strtotime('-2weeks Friday +18 hours');
        $to = strtotime('-1weeks Friday +18 hours');
        $fromDate = date('d-m-Y', $from);
        $toDate = date('d-m-Y', $to);

        $countWeeklyTracks = $this->getWeeklyTrackChart($from, $to, null, $user);
        $dailyTracks = $this->getDailyTrack($user);
        $data = (object)[
            'countWeeklyTracks' => $countWeeklyTracks,
            'weeklyTracks' => (object)['track' => array_slice($countWeeklyTracks->track, 0, 9)],
            'topAlbums' => $this->getTopAlbums($from, $to, 9, $user),
            'weeklyArtists' => $this->getWeeklyArtist($from, $to, $user),
            'dailyTracks' => is_countable($dailyTracks->track) || empty($dailyTracks->track) ? $dailyTracks : (object)['track' => array($dailyTracks->track)], //Sets single tracks (currently listening), to an object following the correct formatting
            'getTopTags' => $this->getTopTags($user),
            'weeklyRunningTracks' => $this->getWeeklyTrackChart($to, time(), null, $user)
        ];
        $userData = $userCountWeeklyTracks = null;
        //For compare page, gets the data for the logged in user.
        if (Route::currentRouteName() == 'lastfm.compare') {
            $userCountWeeklyTracks = $this->getWeeklyTrackChart($from, $to, null, Auth::user()->lastfm);
            $dailyTracks = $this->getDailyTrack(Auth::user()->lastfm);
            $userData = (object)[
                'countWeeklyTracks' => $userCountWeeklyTracks,
                'weeklyTracks' => (object)['track' => array_slice($userCountWeeklyTracks->track, 0, 9)],
                'topAlbums' => $this->getTopAlbums($from, $to, 9, Auth::user()->lastfm),
                'weeklyArtists' => $this->getWeeklyArtist($from, $to, Auth::user()->lastfm),
                'dailyTracks' => is_countable($dailyTracks->track) || empty($dailyTracks->track) ? $dailyTracks : (object)['track' => array($dailyTracks->track)], //Sets single tracks (currently listening), to an object following the correct formatting
                'getTopTags' => $this->getTopTags(Auth::user()->lastfm),
                'weeklyRunningTracks' => $this->getWeeklyTrackChart($to, time(), null, Auth::user()->lastfm)
            ];
//            dd($userData, $data, $dailyTracks, empty($dailyTracks->track), is_countable($dailyTracks->track));

            return view('lastfm.compare', compact('fromDate', 'toDate', 'countWeeklyTracks', 'userCountWeeklyTracks', 'userData', 'data', 'user'));
        }

        return view('lastfm.index', compact('fromDate', 'toDate', 'countWeeklyTracks', 'userCountWeeklyTracks', 'userData', 'data', 'user'));
    }

    public function getTopAlbums($from, $to, $limit, $user)
    {
        $recentResponse = Http::get('https://ws.audioscrobbler.com/2.0', [
            'method' => 'user.getTopAlbums',
            'api_key' => 'ad5a8aacfd3a692dff389c55a849abe6',
            'user' => $user,
            'limit' => $limit,
            'from' => $from,
            'to' => $to,
            'format' => 'json',
            'period' => '7day' //overall,7day,1month,3month,6month,12month
        ]);

//        dd(json_decode($recentResponse->body()));
        return json_decode($recentResponse->body())->topalbums;
    }

    public function getDailyTrack($user)
    {
        $from = strtotime(date("Y-m-d 00:00:01"));
        $recentResponse = Http::get('https://ws.audioscrobbler.com/2.0', [
            'method' => 'user.getRecentTracks',
            'api_key' => 'ad5a8aacfd3a692dff389c55a849abe6',
            'user' => $user,
//            'limit' => 1,
            'nowplaying' => true,
            'format' => 'json',
            'from' => $from
        ]);
        return json_decode($recentResponse->body())->recenttracks;
    }

    public function getTopTags($user)
    {
        //TODO: fix a way for getting tags, think i need track.getTopTags and put track+artist in it
        $recentResponse = Http::get('https://ws.audioscrobbler.com/2.0', [
            'method' => 'user.getTopTags',
            'user' => $user,
            'api_key' => 'ad5a8aacfd3a692dff389c55a849abe6',
            'format' => 'json'
//            'limit' => 10
        ]);
        return json_decode($recentResponse->body())->toptags;
    }

    public function getWeeklyTrackChart($from, $to, $limit, $user)
    {
        $recentResponse = Http::get('https://ws.audioscrobbler.com/2.0', [
            'method' => 'user.getWeeklyTrackChart',
            'api_key' => 'ad5a8aacfd3a692dff389c55a849abe6',
            'user' => $user,
            'from' => $from,
            'to' => $to,
            'limit' => $limit,
            'format' => 'json',
        ]);

//        dd($from, date('d.m.y H:i:s', $from), $to, date('d.m.y H:i:s', $to), json_decode($recentResponse->body()));

        return json_decode($recentResponse->body())->weeklytrackchart;
    }

    public function getWeeklyArtist($from, $to, $user)
    {
        $recentResponse = Http::get('https://ws.audioscrobbler.com/2.0', [
            'method' => 'user.getweeklyartistchart',
            'api_key' => 'ad5a8aacfd3a692dff389c55a849abe6',
            'user' => $user,
            'limit' => 10,
            'from' => $from,
            'to' => $to,
            'nowplaying' => true,
            'format' => 'json'
        ]);

        return json_decode($recentResponse->body())->weeklyartistchart;
    }


    public function getRecentTracks($user)
    {
        $recentResponse = Http::get('https://ws.audioscrobbler.com/2.0', [
            'method' => 'user.getRecentTracks',
            'api_key' => 'ad5a8aacfd3a692dff389c55a849abe6',
            'user' => $user,
            'limit' => 1,
            'nowplaying' => true,
            'format' => 'json'
        ]);
        return json_decode($recentResponse->body())->recenttracks;
    }

    public function getFriendsLastfmInfo()
    {
        $users = User::pluck('lastfm');
        $friendsFeed = array();
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
                array_push($friendsFeed, array(
                    'user' => $user,
                    'artist' => $recentTracks->track[0]->artist->{'#text'},
                    'song' => $recentTracks->track[0]->name
                ));
            }
        }

        return $friendsFeed;
    }
}
