<?php

namespace App\Http\Controllers;

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
        // Return with greeting
        return view('home', compact('greeting'));
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
}
