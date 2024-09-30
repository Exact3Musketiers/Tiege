<?php

namespace App\Http\Controllers;

use App\Models\SteamReview;
use App\Services\News;
use App\Services\Weather;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        // Get all page information
        $greeting = $this->getGreetings();
        $weather = Weather::getWeather(cached: true);
        $news = News::readNews(8);
        $steamReview = [];

        if (SteamReview::all()->isNotEmpty()) {
            $steamReview = SteamReview::all()->random(1)->first();
            $steamReview->load('user');
        }

        // Return with greeting and weather
        return view('home', ['greeting' => $greeting, 'weather' => $weather, 'news' => $news, 'steamReview' => $steamReview]);
    }

    // Search the internet.
    public function search(Request $request)
    {
        // Make google search
        $search = str_replace(' ', '+', $request->search);
        $url = 'https://www.google.com/search?q=' . $search;

        // If search looks like a webadres search for a top level domain
        if (strpos($request->search, '.') != null) {
            // Get top level domain
            $site = $request->search;
            $tld = explode(".", parse_url($site, PHP_URL_HOST));

            // If request contains space or contains a top level domain remove prefixes and redirect
            if (!str_contains($site, ' ') && count($tld) > 0) {
                $site = str_replace(['https://', 'http://', 'www.'], '', $site);
                $site = 'https://' . $site;
                return redirect()->away($site);
            }
        }

        // Else search google
        return redirect()->away($url);
    }

    /**
     * @return array
     */
    public function getGreetings(): string
    {
        $hour = Carbon::now()->format('H');

        $timeOfDayGreeting = 'Goedendag';

        if ($hour < 24) {
            $timeOfDayGreeting = 'Goedenavond ';
        }
        if ($hour < 18) {
            $timeOfDayGreeting = 'Goedemiddag ';
        }
        if ($hour < 12) {
            $timeOfDayGreeting = 'Goedemorgen ';
        }
        if ($hour < 6) {
            $timeOfDayGreeting = 'Goedenacht ';
        }

        // array of greetings
        $greetings = [
            'Hallo ',
            'Gedag ',
            'Gegroet ',
            'Hoi ', 'Guten Tag, ',
            'Jo Jo Jo ',
            'Hey! het is broederman ',
            'Wow, dat is de enige echte ',
            'Tadaa! ',
        ];

        // Merge the time dependent greeting with greetings array and randomize the order
        $greetings[] = $timeOfDayGreeting;
        shuffle($greetings);

        return $greetings[0];
    }
}
