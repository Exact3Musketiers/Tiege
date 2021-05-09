<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return view('home');
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
                    // Removes aal domain prefixes
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
