<?php

namespace App\Http\Controllers;

use App\Services\ScraperService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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

    public function index(ScraperService $scraperService)
    {
        //TODO: user configurable
        $recentResponse = Http::get('https://ws.audioscrobbler.com/2.0', [
            'method' => 'user.getRecentTracks',
            'api_key' => 'ad5a8aacfd3a692dff389c55a849abe6',
            'user' => 'mrgollem',
            'limit' => 1,
            'nowplaying' => true,
            'format' => 'json'
        ]);
        $recentTracks = json_decode($recentResponse->body())->recenttracks;

        $artist = $this->formatSongDetails($recentTracks->track[0]->artist->{'#text'});
        $song = $this->formatSongDetails($recentTracks->track[0]->name);

        //TODO: make genius.com as fallback
        $url = 'https://www.musixmatch.com/lyrics/' . $artist . '/' . $song;

//        dd($artist, $song, $recentTracks->track[0]->name);
        $data = $scraperService->scrape($url);
        $scrapedLyrics = '';
        if (count($data['lyrics']) > 1)
            $result = $data['lyrics'][0] . ' ' . $data['lyrics'][1];
        else
            $result = $data['lyrics'][0];

        preg_match_all('/[A-Z][^A-HJ-Z]+/', $result, $scrapedLyrics);

        return view('lyrics.index', compact('scrapedLyrics', 'recentTracks'));
    }
}
