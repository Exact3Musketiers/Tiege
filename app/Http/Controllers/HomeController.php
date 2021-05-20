<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $this->writeNews();

        // Get times
        $six = Carbon::createFromFormat('G:i', '06:00');
        $twelve = Carbon::createFromFormat('G:i', '12:00');
        $eighteen = Carbon::createFromFormat('G:i', '18:00');
        $zero = Carbon::createFromFormat('G:i:s', '23:59:59');
        // Check current time
        $morning = Carbon::now()->isBetween($six,  $twelve);
        $afternoon = Carbon::now()->isBetween($twelve,  $eighteen);
        $evening = Carbon::now()->isBetween($eighteen,  $zero);
        $night = Carbon::now()->between($zero,  $six);
        $daypart = '';
        // Get current daypart
        if ($morning === true) {
            $daypart =  'Goedemorgen';
        }
        elseif ($afternoon) {
            $daypart = 'Goedemiddag';
        }
        elseif ($evening) {
            $daypart = 'Goedenavond';
        }
        elseif ($night) {
            $daypart = 'Goedenacht';
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
        // Merge daypart with greetings array
        array_push($greetings, $daypart);
        // Randomize array order
        shuffle($greetings);

        // Get the first greeting
        $greeting = $greetings[0];

        // Get weather
        $weather = getWeather();

        // Get news
        $news = $this->readNews(6);

        // Return with greeting and weather
        return view('home', compact('greeting', 'weather', 'news'));
    }

    /**
     * Search the internet.
     *
     *
     */
    public function search(Request $request)
    {
        // Make google search
        $search = str_replace(' ', '+', $request->search);
        $url = 'https://www.google.com/search?q=' . $search;
        // Check if request contains a dot
        if (strpos($request->search, '.') != null)
        {
            // Get top level domain
            $site = $request->search;
            $tld = explode(".", parse_url($site, PHP_URL_HOST));
            // checks if request contains space
            if (!str_contains($site, ' '))
            {
                // Check if request contains top level domain
                if (count($tld) > 0);
                {
                    // Removes all domain prefixes
                    $site = str_replace('https://', '', $site);
                    $site = str_replace('http://', '', $site);
                    $site = str_replace('www.', '', $site);

                    // Adds https:// to domain name
                    $site = 'https://' . $site;
                    // Opens site
                    return redirect()->away($site);
                }
            }
            else
            {
                // Searches google
                return redirect()->away($url);
            }
        }
        else
        {
            // Searches google
            return redirect()->away($url);
        }
    }

    /**
     * Get the wheather
     *
     *
     */
    // public function weather()
    // {

    // }

    public function getNews()
    {
        $newsResponse = Http::get('https://newsapi.org/v2/top-headlines', [
            'country' => 'nl',
            'pageSize' => '20',
            'apiKey' => 'd0e021d0387b4426b1e2315b8f62f1ed',
        ]);

        return $newsResponse;
    }

    public function writeNews()
    {
        if (!file_exists('news.json')) {
            $newsResponse = $this->getNews();
            file_put_contents('news.json', $newsResponse);
        }
        $currentTime = time();
        $age = filemtime('news.json');
        $timeDifference = $currentTime - $age;
        if ($timeDifference >= 3600) {
            // Call NewsAPI
            $newsResponse = $this->getNews();
            file_put_contents('news.json', $newsResponse);
        }
    }

    public function readNews($limit)
    {
        if (file_exists('news.json'))
        {
            $updatedAt = date('H:m:s', filemtime('news.json'));
            $news = json_decode(file_get_contents('news.json'));
            $articles = array_slice($news->articles, 0, $limit);
            $news = [
                'articles' => $articles,
                'updatedAt' => $updatedAt,
            ];
        }
        else
        {
            $news = [
                'error' => 'Er is niets nieuws gebeurd'
            ];
        }

        return $news;
    }
}
