<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SteamReview;
use App\Models\User;
use Illuminate\Support\Arr;

class SteamReviewController extends Controller
{
    public function all()
    {
        $reviews = SteamReview::all()->sortBy('steam_appid');

        return view('steam.review.all', compact('reviews'));
    }

    public function index(User $user)
    {
        if ($user->getKey() !== auth()->user()->getKey()) {
            abort(403);
        }

        $reviews = SteamReview::whereUserId(auth()->user()->getKey())->orderBy('steam_appid')->get();

        return view('steam.review.index', compact('user', 'reviews'));
    }

    public function edit(User $user, SteamReview $review)
    {
        if ($user->getKey() !== auth()->user()->getKey()) {
            abort(403);
        }

        return view('steam.review.edit', compact('user', 'review'));
    }

    public function store(Request $request, User $user)
    {
        if ($user->getKey() !== auth()->user()->getKey()) {
            abort(403);
        }

        $validated = $request->validate([
            'review' => ['required', 'string', 'min:3']
        ]);

        $validated['recomended'] = $request->has('recomended');
        $wantedData = ['steam_appid', 'name', 'playtime_forever'];
        $steam_data = Arr::only(cache('user.'.$user->getKey().'.selectedGameInfo'), $wantedData);
        $user_id = ['user_id' => $user->getKey()];

        SteamReview::create($validated + $steam_data + $user_id);

        return back();
    }

    public function update(Request $request, User $user, SteamReview $steamReview)
    {
        if ($user->getKey() !== auth()->user()->getKey()) {
            abort(403);
        }

        $validated = $request->validate([
            'review' => ['required', 'string', 'min:3']
        ]);

        $validated['recomended'] = $request->has('recomended');

        $steamReview->update($validated);


        return back();
    }
}
