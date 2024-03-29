<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WikiPath;
use App\Services\Wiki;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class WikiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(User $user, Request $request)
    {
        $wiki = [];
        $duplicate = true;

        // Check if user is signed in
        if (Auth::check()) {
            while ($duplicate) {
                // If the request has the word reload delete all cookies
                if (request()->has('reload')) {
                    Wiki::session_forget($request, ['wiki_page_1', 'wiki_page_2']);
                }

                // Load page a and b into cache
                if (!$request->session()->has('wiki_page_1')) {
                    $page1 = Wiki::getRandomPage();
                    $request->session()->put('wiki_page_1', [$page1, Wiki::getWikiDescription($page1)]);
                }

                if (!$request->session()->has('wiki_page_2')) {
                    $page2 = Wiki::getRandomPage();
                    $request->session()->put('wiki_page_2', [$page2, Wiki::getWikiDescription($page2)]);
                }

                $wiki[0] = $request->session()->get('wiki_page_1');
                $wiki[1] = $request->session()->get('wiki_page_2');

                // If a duplicate is generated refresh
                if ($wiki[0] === $wiki[1]) {
                    $request->session()->forget('wiki_page_2');
                } else {
                    $duplicate = false;
                }
            }
        }

        $wikiPath = WikiPath::with('user', 'wikiChallenge')->get();

        // Create a leaderboard
        $scores = $wikiPath
                    ->where('finished', true)
                    ->whereNull('wiki_challenge_id')
                    ->sortByDesc('created_at');

        $scores = $scores->mapToGroups(function ($item) {
            return [$item['start'].'_'.$item['end'] => $item];
        })->take(5);

        // Create a recent challenge board
        $challenges = $wikiPath
                    ->whereNotNull('wiki_challenge_id')
                    ->sortByDesc('created_at')
                    ->where('created_at', '>', Carbon::now()->subDays(7));

        $challenges = $challenges->mapToGroups(function ($item) {
            return [$item['start'].'_'.$item['end'].'_'.$item['wiki_challenge_id'] => $item];
        })->take(5);

        return view('wiki.index', compact('wiki', 'scores', 'challenges'));
    }

    // Refresh one of the pages required for the game
    public function refreshPage(Request $request)
    {
        // Check if the request is legit
        $validated = $request->validate([
            'page' => [
                'required',
                Rule::in(['1','2']),
            ],
        ]);
        // Refresh page a or be
        $request->session()->forget('wiki_page_' . $validated['page']);
        // Return to wiki
        return redirect(route('wiki.index'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if ($request->has('challenge')) {
            $challenge = explode('_', $request->challenge);

            Wiki::session_forget($request, ['wiki_page_1', 'wiki_page_2']);

            $page1 = $challenge[0];
            $page2 = $challenge[1];

            // Load page a and b into the session
            session()->put('wiki_page_1', [$page1, Wiki::getWikiDescription($page1)]);
            session()->put('wiki_page_2', [$page2, Wiki::getWikiDescription($page2)]);
        }

        $wiki = WikiPath::create([
            'user_id' => Auth::user()->getKey(),
            'wiki_challenge_id' => $request->query('challenge_id'),
            'start' => $request->session()->get('wiki_page_1')[0],
            'end' => $request->session()->get('wiki_page_2')[0],
        ]);

        return redirect(route('wiki.show', [$wiki]));
    }

    /**
     * Display the specified resource.
     *
     * @param  WikiPath  $wiki
     * @param  User  $user
     * @param  Request  $request
     * @return \Illuminate\Contracts\View\View
     */
    public function show(WikiPath $wiki, User $user, Request $request)
    {
        $page = Wiki::wikiURL($wiki->start);

        if ($request->has('pg')) {
            $page = Wiki::wikiURL($request['pg']);
        }

        $count = $request->session()->get('click_count') ?? 0;

        if (!$wiki->finished) {
            $wiki->update(['click_count' => $count]);
        }

        if ($request->session()->get('throughRedirectPage')) {
            $count = $count - 1;
            $request->session()->forget('throughRedirectPage');
        }

        if ($request->session()->get('toErrorPage')) {
            $count = $count - 2;
            $request->session()->forget('toErrorPage');
        }

        if ($request->session()->get('urlTampering')) {
            $count = $count + 4;
            $request->session()->forget('urlTampering');
        }

        $request->session()->forget('click_count');

        $request->session()->put('click_count', $count + 1);
        $count = $request->session()->get('click_count');

        if (Str::lower($page) == Str::replace(' ', '_', Str::lower($wiki->end))) {
            $request->session()->forget('click_count');
            $wiki->update(['finished' => true]);

            $challenges = WikiPath::with('WikiChallenge')->where('wiki_challenge_id', $wiki->wiki_challenge_id)->get();

            if (! $challenges->where('finished', false)->count() > 0) {
                $challenges->first()->wikiChallenge()->update(['state' => 2]);
            }

            $count = $wiki->click_count;
            return view('wiki.victory', compact('wiki', 'count'));
        }

        $body = Wiki::getWikiPage($page, $wiki->getKey());

        return view('wiki.show', compact('wiki', 'body', 'count'));
    }
}
