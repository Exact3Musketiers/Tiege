<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Services\Wiki;
use App\Models\User;
use App\Models\WikiPath;
use Illuminate\Support\Facades\URL;

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
        // Check if use is signed in
        if (Auth::check()) {
            // If the rquest has the word reload delte all cookies
            if (request()->has('reload')) {
                Cache::forget('user.'.$user->getKey().'.wiki_page_1');
                Cache::forget('user.'.$user->getKey().'.wiki_page_2');
            }
            // Load page a and b into cache
            $wiki[0] = Cache::remember('user.'.$user->getKey().'.wiki_page_1', 3600, function () {
                return urldecode(str_replace('_', ' ', Wiki::getRandomPage()));
            });
            $wiki[1] = Cache::remember('user.'.$user->getKey().'.wiki_page_2', 3600, function () {
                return urldecode(str_replace('_', ' ', Wiki::getRandomPage()));
            });
        }

        
        return view('wiki.index', compact('wiki'));
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
            'start' => cache('user.'.$user->getKey().'.wiki_page_1'),
            'end' => cache('user.'.$user->getKey().'.wiki_page_2'),
        ]);

        return redirect(route('wiki.show', [$wiki]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(WikiPath $wiki, Request $request)
    {
        $page = Wiki::wikiURL($wiki->start);

        if ($request->has('pg')) {
            $page = Wiki::wikiURL($request['pg']);
        }

        $body = Wiki::getWikiPage($page, $wiki->getKey());
        return view('wiki.show', compact('wiki', 'body'));
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
