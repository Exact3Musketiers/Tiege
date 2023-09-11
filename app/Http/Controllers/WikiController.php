<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Services\Wiki;
use App\Models\User;
use App\Models\WikiPath;
use Illuminate\Support\Str;

class WikiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user, Request $request)
    {
        $wiki = [];
        // Check if user is signed in
        if (Auth::check()) {
            // If the rquest has the word reload delte all cookies
            if (request()->has('reload')) {
                $request->session()->forget('wiki_page_1');
                $request->session()->forget('wiki_page_2');
            }
            
            $owner = '';
            
            if ($request->has('shared')) {
                $request->session()->forget('wiki_page_1');
                $request->session()->forget('wiki_page_2');

                $info = str_replace(' ', '+', $request->get('shared'));
                $request->session()->put('sharable_link', $info);

                $explode = explode('+', $info);

                $owner = User::whereId($explode[1])->pluck('name');

                $options = explode('-', $explode[2]);

                $request->session()->put('wiki_page_1', [Wiki::unWikiURL($options[0]), Wiki::getWikiDescription($options[0])]);
                $request->session()->put('wiki_page_2', [Wiki::unWikiURL($options[1]), Wiki::getWikiDescription($options[1])]);
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

                return redirect(route('wiki.index'));
            }
        }

        // Create a leaderboard
        $scores = WikiPath::with('user')
                    ->whereNotNull('click_count')
                    ->orderBy('created_at', 'DESC')
                    ->get();

        $scores = $scores->mapToGroups(function ($item, $key) {
            return [$item['start'].'_'.$item['end'] => $item];
        });

        return view('wiki.index', compact('wiki', 'scores', 'owner'));
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

    // Generate a link to share with other players
    public function generateLink(Request $request)
    {
        $page1 = Wiki::wikiURL($request->session()->get('wiki_page_1')[0]);
        $page2 = Wiki::wikiURL($request->session()->get('wiki_page_2')[0]);

        $string = Str::random(6);

        $info = $string.'+'.auth()->user()->getKey().'+'.$page1.'-'.$page2;

        $request->session()->put('sharable_link', $info);

        return back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(User $user, Request $request)
    {
        if ($request->has('challenge')) {
            $challenge = explode('_', $request->challenge);

            $request->session()->forget('wiki_page_1');
            $request->session()->forget('wiki_page_2');
            $page1 = $challenge[0];
            $page2 = $challenge[1];

            // Load page a and b into the session
            $wiki[0] = $request->session()->put('wiki_page_1', [$page1, Wiki::getWikiDescription($page1)]);
            $wiki[1] = $request->session()->put('wiki_page_2', [$page2, Wiki::getWikiDescription($page2)]);
        }

        $store = [];
        
        if ($request->session()->has('sharable_link')) {
            $info = $request->session()->get('sharable_link');

            $explode = explode('+', $info);

            $store = [
                'shared_info' => $explode[0].'-'.$explode[1]
            ];
        }

        $wiki = WikiPath::create([
            'user_id' => Auth::user()->getKey(),
            'start' => $request->session()->get('wiki_page_1')[0],
            'end' => $request->session()->get('wiki_page_2')[0],
        ] + $store);

        return redirect(route('wiki.show', [$wiki]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(WikiPath $wiki, User $user, Request $request)
    {
        $page = Wiki::wikiURL($wiki->start);

        if ($request->has('pg')) {
            $page = Wiki::wikiURL($request['pg']);
        }
        
        $count = $request->session()->get('click_count') ?? 0;

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
            

            if (is_null($wiki->click_count)) {
                $wiki->update(['click_count' => $count]);
            } else {
                $count = $wiki->click_count;
            }

            if (! is_null($wiki->sharable_info) && $request->session()->has('sharable_link')) {
                $info = $request->session()->get('sharable_link');
                $info = explode('+', $info);

                WikiPath::whereSharableInfo('');
                $request->session()->forget('sharable_link');
            }
            
            return view('wiki.victory', compact('wiki', 'count'));
        }

        $body = Wiki::getWikiPage($page, $wiki->getKey());    

        return view('wiki.show', compact('wiki', 'body', 'count'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
