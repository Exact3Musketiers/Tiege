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
            $musicFeed = [
                'recentTracks' => app('App\Http\Controllers\LastfmController')->getRecentTracks(),
                'friendsTracks' => app('App\Http\Controllers\LastfmController')->getFriendsLastfmInfo()
            ];
            $view->with('musicFeed', $musicFeed);
        });
    }
}
