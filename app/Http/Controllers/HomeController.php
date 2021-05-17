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
        $weather = $this->weather();

        // Get news
        $news = $this->readNews();

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
    public function weather()
    {
        // Call openweathermap api
        $weatherResponse = Http::get('api.openweathermap.org/data/2.5/weather', [
            'q' => 'sneek,nl',
            'lang' => 'nl',
            'units' => 'metric',
            'APPID' => '2a00ff331d7e11c1e9e53406e66efb78',
        ]);
        // Decode json
        $weather = json_decode($weatherResponse->body());
        // Check if data exists
        if (isset($weather->weather[0])) {
            // Get temoperature
            $temperatureFeels = $weather->main->temp;
            $main = $weather->weather[0]->main;
            // To Jas Or Not To Jas
            $toJas = true;
            if ($temperatureFeels >= 15) {
                if ($main !== 'Rain') {
                    $toJas = false;
                }
            }
            // Get wind
            $windDeg = $weather->wind->deg;
            $windSpeed = $weather->wind->speed;
            $windText = '';
            $windBft = '';
            // Wind speed
            switch ($windSpeed) {
                case $windSpeed >= 0.0 && $windSpeed <= 0.2:
                    $windText = 'windstil';
                    $windBft = 0;
                    break;
                case $windSpeed >= 0.3 && $windSpeed <= 1.5:
                    $windText = 'zwakke wind';
                    $windBft = 1;
                    break;
                case $windSpeed >= 1.6 && $windSpeed <= 3.3:
                    $windText = 'zwakke wind';
                    $windBft = 2;
                    break;
                case $windSpeed >= 3.4 && $windSpeed <= 5.4:
                    $windText = 'matige wind';
                    $windBft = 3;
                    break;
                case $windSpeed >= 5.5 && $windSpeed <= 7.9:
                    $windText = 'matige wind';
                    $windBft = 4;
                    break;
                case $windSpeed >= 8.0 && $windSpeed <= 10.7:
                    $windText = 'vrij krachtige wind';
                    $windBft = 5;
                    break;
                case $windSpeed >= 10.8 && $windSpeed <= 13.8:
                    $windText = 'krachtige wind';
                    $windBft = 6;
                    break;
                case $windSpeed >= 13.9 && $windSpeed <= 17.1:
                    $windText = 'harde wind';
                    $windBft = 7;
                    break;
                case $windSpeed >= 17.2 && $windSpeed <= 20.7:
                    $windText = 'stormachtige wind';
                    $windBft = 8;
                    break;
                case $windSpeed >= 20.8 && $windSpeed <= 24.4:
                    $windText = 'storm';
                    $windBft = 9;
                    break;
                case $windSpeed >= 24.5 && $windSpeed <= 28.4:
                    $windText = 'zware storm';
                    $windBft = 10;
                    break;
                case $windSpeed >= 28.5 && $windSpeed <= 32.6:
                    $windText = 'zeer zware storm';
                    $windBft = 11;
                    break;
                case $windSpeed >= 32.7:
                    $windText = 'orkaan';
                    $windBft = 12;
                    break;
            }
            // Wind direction
            switch ($windDeg) {
                case $windDeg >= 349 && $windDeg <= 360 || $windDeg >= 1 && $windDeg <= 11:
                    $windDirection = 'Noorden';
                    break;
                case $windDeg >= 12 && $windDeg <= 33:
                    $windDirection = 'Noord Noord Oosten';
                    break;
                case $windDeg >= 34 && $windDeg <= 55:
                    $windDirection = 'Noord Oosten';
                    break;
                case $windDeg >= 56 && $windDeg <= 77:
                    $windDirection = 'Oost Noord Oosten';
                    break;
                case $windDeg >= 78 && $windDeg <= 100:
                    $windDirection = 'Oosten';
                    break;
                case $windDeg >= 101 && $windDeg <= 123:
                    $windDirection = 'Oost Zuid Oosten';
                    break;
                case $windDeg >= 124 && $windDeg <= 145:
                    $windDirection = 'Zuid Oosten';
                    break;
                case $windDeg >= 146 && $windDeg <= 168:
                    $windDirection = 'Zuid Zuid Oosten';
                    break;
                case $windDeg >= 169 && $windDeg <= 190:
                    $windDirection = 'Zuid';
                    break;
                case $windDeg >= 191 && $windDeg <= 211:
                    $windDirection = 'Zuid Zuid Westen';
                    break;
                case $windDeg >= 212 && $windDeg <= 236:
                    $windDirection = 'Zuid Westen';
                    break;
                case $windDeg >= 237 && $windDeg <= 258:
                    $windDirection = 'West Zuid Westen';
                    break;
                case $windDeg >= 259 && $windDeg <= 280:
                    $windDirection = 'Westen';
                    break;
                case $windDeg >= 281 && $windDeg <= 303:
                    $windDirection = 'West Noord Westen';
                    break;
                case $windDeg >= 304 && $windDeg <= 325:
                    $windDirection = 'Noord Westen';
                    break;
                case $windDeg >= 326 && $windDeg <= 348:
                    $windDirection = 'Noord Noord Westen';
                    break;
            }
            // All data in array
            $allWeather = [
                'temperature' => $weather->main->temp,
                'temperatureMax' => $weather->main->temp_max,
                'temperatureMin' => $weather->main->temp_min,
                'temperatureFeels' => $weather->main->feels_like,
                'windText' => $windText,
                'windBft' => $windBft,
                'windDirection' => $windDirection,
                'type' => $weather->weather[0]->description,
                'toJas' => $toJas,
            ];
        }
        // If check fails send error message
        else {
            $allWeather = ['error' => 'De api is boos'];
        }
        // Return weather
        return $allWeather;

    }

    public function getNews()
    {
        $newsResponse = Http::get('https://newsapi.org/v2/top-headlines', [
            'country' => 'nl',
            'pageSize' => '5',
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

    public function readNews()
    {


        if (file_exists('news.json'))
        {
            $updatedAt = date('H:m:s', filemtime('news.json'));
            $news = json_decode(file_get_contents('news.json'));
            $news = [
                'articles' => $news->articles,
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
