<?php

namespace App\Http\Controllers;

use App\Services\ScraperService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LastfmController extends Controller
{
    public function index(ScraperService $scraperService)
    {
        $recentTracks = $scrapedLyrics = '';
        //TODO: user configurable
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

        $artist = ucfirst(strtolower(str_replace(' ', '-', $recentTracks->track[0]->artist->{'#text'})));
        $song = strtolower(str_replace(`'`, '', str_replace(' ', '-', $recentTracks->track[0]->name)));
        $url = 'https://genius.com/' . $artist . '-' . $song . '-lyrics';
        $data = $scraperService->scrap($url);
        $scrapedLyrics = '';


        //TODO: replace chorus, verse en dat soort meuk met een teken wat we kunnen gebruiken om te replacen met een br'tje
        preg_match_all('/[A-Z][^A-Z]*/',$data['lyrics'][0],$scrapedLyrics);
//        return view('lastfm.index', compact('scrapedLyrics', 'recentTracks'));


        return view('lastfm.index', compact('scrapedLyrics', 'recentTracks'));
    }

//    public function fetch(ScraperService $scraperService, Request $request)
//    {
//        $recentResponse = Http::get('https://ws.audioscrobbler.com/2.0', [
//            'method' => 'user.getRecentTracks',
//            'api_key' => 'ad5a8aacfd3a692dff389c55a849abe6',
//            'user' => 'mrgollem',
//            'limit' => 1,
//            'nowplaying' => true,
//            'format' => 'json'
//        ]);
//        $recentTracks = json_decode($recentResponse->body());
//        $recentTracks = $recentTracks->recenttracks;
//
//
//        return view('lastfm.index', compact('scrapedLyrics', 'recentTracks'));
//        $recentResponse = Http::get('https://private-anon-d26b57a4dd-lyricsovh.apiary-proxy.com/v1/Coldplay/Adventure%20of%20a%20Lifetime');
//        $recentTracks = json_decode($recentResponse->body());
//        dd($recentTracks);
//    }
}
