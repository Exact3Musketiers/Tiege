<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;


class MusicServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('includes.music', function ($view) {
            // if (empty(Auth::user()->lastfm))
            //     $musicFeed = [
            //         'friendsTracks' => app('App\Http\Controllers\LastfmController')->getFriendsLastfmInfo()
            //     ];
            // else
            //     $musicFeed = [
            //         'recentTracks' => app('App\Http\Controllers\LastfmController')->getRecentTracks(Auth::user()->lastfm),
            //         'friendsTracks' => app('App\Http\Controllers\LastfmController')->getFriendsLastfmInfo()
            //     ];
            $musicFeed = [];

            if (!empty(Auth::user()->lastfm))
                $musicFeed = [
                    'recentTracks' => app('App\Http\Controllers\LastfmController')->getRecentTracks(Auth::user()->lastfm)
                ];
            $view->with('musicFeed', $musicFeed);
        });
    }
}
