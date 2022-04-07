<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SteamReview;
use App\Models\User;

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
}
