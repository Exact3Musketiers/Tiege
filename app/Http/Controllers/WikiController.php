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
    public function index(User $user)
    {
        $wiki = [];
        // Check if user is signed in
        if (Auth::check()) {
            // If the rquest has the word reload delte all cookies
            if (request()->has('reload')) {
                Cache::forget('user.'.$user->getKey().'.wiki_page_1');
                Cache::forget('user.'.$user->getKey().'.wiki_page_2');
            }
            // Load page a and b into cache
            $wiki[0] = Cache::remember('user.'.$user->getKey().'.wiki_page_1', 3600, function () {
                $page = Wiki::getRandomPage();
                return [$page, Wiki::getWikiDescription($page)];
            });
            $wiki[1] = Cache::remember('user.'.$user->getKey().'.wiki_page_2', 3600, function () {
                $page = Wiki::getRandomPage();
                return [$page, Wiki::getWikiDescription($page)];
            });
            // If a duplicate is generated refresh
            if ($wiki[0] === $wiki[1]) {
                Cache::forget('user.'.$user->getKey().'.wiki_page_2');

                return redirect(route('wiki.index'));
            }
        }

        // Create a leaderboard
        $scores = WikiPath::with('user')
                    ->whereNotNull('click_count')
                    ->orderBy('created_at', 'DESC')
                    ->orderBy('click_count', 'ASC')
                    ->get();

        $scores = $scores->mapToGroups(function ($item, $key) {
            return [$item['start'].'_'.$item['end'] => $item];
        });
// dd($scores);
        return view('wiki.index', compact('wiki', 'scores'));
    }

    // Refresh one of the pages required for the game
    public function refreshPage(Request $request, User $user)
    {
        // Check if the request is legit
        $validated = $request->validate([
            'page' => [
                'required',
                Rule::in(['1','2']),
            ],
        ]);
        // Refresh page a or be
        Cache::forget('user.'.$user->getKey().'.wiki_page_' . $validated['page']);
        // Return to wiki
        return redirect(route('wiki.index'));
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
    public function store(User $user)
    {
        $wiki = WikiPath::create([
            'user_id' => Auth::user()->getKey(),
            'start' => cache('user.'.$user->getKey().'.wiki_page_1')[0],
            'end' => cache('user.'.$user->getKey().'.wiki_page_2')[0],
        ]);

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

        $count = Cache::get('user.'.$user->getKey().'.count') ?? 0;
        
        Cache::forget('user.'.$user->getKey().'.count');

        $count = Cache::remember('user.'.$user->getKey().'.count', 3600, function () use ($count) {
            return $count + 1;
        });
        
        if (Str::lower($page) == Str::replace(' ', '_', Str::lower($wiki->end))) {
            Cache::forget('user.'.$user->getKey().'.count');

            if (is_null($wiki->click_count)) {
                $wiki->update(['click_count' => $count]);
            } else {
                $count = $wiki->click_count;
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
