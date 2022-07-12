<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Services\Wiki;
use App\Models\User;

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
        if (Auth::check()) {
            if (request()->has('reload')) {
                Cache::forget('user.'.$user->getKey().'.wiki_page_1');
                Cache::forget('user.'.$user->getKey().'.wiki_page_2');
            }
            $w1 = Cache::remember('user.'.$user->getKey().'.wiki_page_1', 3600, function () {
                return str_replace('_', ' ', Wiki::getRandomPage());
            });
            $w2 = Cache::remember('user.'.$user->getKey().'.wiki_page_2', 3600, function () {
                return str_replace('_', ' ', Wiki::getRandomPage());
            });

            $wiki = [$w1, $w2];
        }
        return view('wiki.index', compact('wiki'));
    }

    public function refreshPage(Request $request, User $user)
    {
        $validated = $request->validate([
            'page' => [
                'required',
                Rule::in(['a','b']),
            ],
        ]);

        if ($validated['page'] === 'a') {
            Cache::forget('user.'.$user->getKey().'.wiki_page_1');
        }
        if ($validated['page'] === 'b') {
            Cache::forget('user.'.$user->getKey().'.wiki_page_2');
        }
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
