<?php

namespace App\Http\Controllers;

use App\Services\ScraperService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\User;

class LyricsController extends Controller
{
    public function formatSongDetails($item)
    {
        return
            preg_replace("(((?<=feat)(.*$))|-feat)", '',
                preg_replace('/-Remastered-[0-9]*/', '',
                    preg_replace('/-[0-9]*-Remaster/', '',
                        preg_replace("/(--)/", '-',
                            preg_replace("/(---)/", '-',
                                str_replace(' ', '-',
                                    preg_replace("/[_.!`'#%&,:;<>=@{}~\$\(\)\*\+\/\\\?\[\]\^\|]+/", "-",
                                        preg_replace("/[-_!#%,:;<>=@{}~\$\(\)\*\+\/\\\?\[\]\^\|]+/", "",
                                            $item))))))));
    }

    public function getLastfmInfo()
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
                        'artist' => $recentTracks->track[0]->artist->{'#text'},
                        'song' => $recentTracks->track[0]->name
                    )
                ];
            }
        }
//        dd($friendFeed);
    }


    public function index(ScraperService $scraperService)
    {
        if (Auth::user()->lastfm != null) {
            $recentTracks = $this->getLastfmInfo();

            $artist = $this->formatSongDetails($recentTracks->track[0]->artist->{'#text'});
            $song = $this->formatSongDetails($recentTracks->track[0]->name);


            $data = $scraperService->scrape($artist, $song);
            $service = $data['service'];
            $scrapedLyrics = '';
            if (count($data['lyrics']) > 1)
                $result = $data['lyrics'][0] . ' ' . $data['lyrics'][1];
            else
                $result = $data['lyrics'][0];

            //Removes all letters between brackets
            $result = preg_replace('/\[.*?\]/', '', $result);
            //Creates new line on capital letters, except I
            preg_match_all('/[A-Z][^A-HJ-Z]+/', $result, $scrapedLyrics);


            return view('lyrics.index', compact('scrapedLyrics', 'recentTracks', 'service'));
        }
        $scrapedLyrics[0][0] = 'To use this feature you need Last.FM connected to your account.';
        $recentTracks = null;
        return view('lyrics.index', compact('scrapedLyrics', 'recentTracks'));
    }
}
