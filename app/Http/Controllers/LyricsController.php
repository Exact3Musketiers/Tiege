<?php

namespace App\Http\Controllers;

use App\Services\LyricsScraperService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LyricsController extends Controller
{
    public function index(LyricsScraperService $scraperService, Request $request)
    {
        if (Auth::user()->lastfm != null) {
            $user = $request->query('user');
            if (empty($user))
                $user = Auth::user()->lastfm;

            $recentTracks = app('App\Http\Controllers\LastfmController')->getRecentTracks($user);

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
            //TODO: fix lyrics with (Pantomime Ben Hammersley) and (Bump and Grind David Lee Roth)
//            dd($result, $scrapedLyrics);

            return view('lyrics.index', compact('scrapedLyrics', 'recentTracks', 'service'));
        }
        $scrapedLyrics[0][0] = 'To use this feature you need Last.FM connected to your account.';
        $recentTracks = null;
        return view('lyrics.index', compact('scrapedLyrics', 'recentTracks'));
    }

    public function formatSongDetails($item)
    {
        return
            preg_replace("(((?<=feat)(.*$))|-feat)", '',
                preg_replace('/-Remastered-[0-9]*/', '',
                    preg_replace('/-[0-9]*-Remaster/', '',
                        preg_replace('/(--)/', '-',
                            preg_replace('/(---)/', '-',
                                str_replace(' ', '-',
                                    preg_replace("/[_.!`'#%&,:;<>=@{}~\$\(\)\*\+\/\\\?\[\]\^\|]+/", '-',
                                        preg_replace("/[-_!#%,:;<>=@{}~\$\(\)\*\+\/\\\?\[\]\^\|]+/", '',
                                            $item))))))));
    }
}
