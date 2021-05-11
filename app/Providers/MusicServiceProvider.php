<?php

namespace App\Providers;

use App\Http\Controllers\LyricsController;

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
        View::composer('partials.music', function ($view) {
            $recentTracks = app('App\Http\Controllers\LyricsController')->getLastfmInfo();
            $friendsRecentTracks = app('App\Http\Controllers\LyricsController')->getFriendsLastfmInfo();
            $view->with('recentTracks', $recentTracks);
        });
    }
}
