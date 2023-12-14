<?php

namespace App\Http\Controllers;

use App\Models\WikiChallenges;
use App\Models\WikiPath;
use App\Services\Wiki;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WikiChallengesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $challenge = WikiChallenges::create([
            'user_id' => Auth::user()->getKey(),
            'start' => $request->session()->get('wiki_page_1')[0],
            'end' => $request->session()->get('wiki_page_2')[0],
        ]);

        $request->session()->forget('wiki_page_1');
        $request->session()->forget('wiki_page_2');

        return redirect(route('challenge.show', $challenge));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, WikiChallenges $challenge)
    {
        if ($challenge->user_id !== auth()->user()->getKey()) {
            dump('iemand anders');
        } else {
            dump('De originele dude(tte)');
        }

        // Load page a and b into the session
        if (!$request->session()->has('wiki_page_1')) {
            $request->session()->put('wiki_page_1', [$challenge->start, Wiki::getWikiDescription($challenge->start)]);
        }
        if (!$request->session()->has('wiki_page_2')) {
            $request->session()->put('wiki_page_2', [$challenge->end, Wiki::getWikiDescription($challenge->end)]);
        }

        $wiki[0] = $request->session()->get('wiki_page_1');
        $wiki[1] = $request->session()->get('wiki_page_2');

        return view('wikiChalenge.show', ['challenge' => $challenge, 'wiki' => $wiki]);
    }

    public function start(Request $request, WikiChallenges $challenge) {
        $wiki = [];
        $users = $request->users;
        foreach ($users as $user) {
            $wiki = WikiPath::create([
                'user_id' => $user['id'],
                'wiki_challenge_id' => $challenge->getKey(),
                'start' => $request->session()->get('wiki_page_1')[0],
                'end' => $request->session()->get('wiki_page_2')[0],
            ]);
        }
        return $wiki;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WikiChallenges $wikiChallenges)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WikiChallenges $wikiChallenges)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WikiChallenges $wikiChallenges)
    {
        //
    }
}
