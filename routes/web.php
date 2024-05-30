<?php

use App\Http\Middleware\HasValidHash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/search', [App\Http\Controllers\HomeController::class, 'search'])->name('home.search');

Route::get('/numbers/currency', [App\Http\Controllers\CurrencyController::class, 'index'])->name('currency');
Route::get('/policy', [App\Http\Controllers\PagesController::class, 'policy'])->name('policy');


Route::resource('/numbers/random', App\Http\Controllers\RandomController::class);

Route::post('/currencyFetch', [App\Http\Controllers\CurrencyController::class, 'fetch'])->name('currency.fetch');

Route::get('/s', [App\Http\Controllers\SarcasmController::class, 'index'])->name('sarcasm');
Route::get('/UwU', [App\Http\Controllers\PagesController::class, 'uwu'])->name('uwu');

Route::get('/steam', [App\Http\Controllers\SteamController::class, 'index'])->name('steam.index');
Route::get('steam/user/{user}', [App\Http\Controllers\SteamController::class, 'show'])->name('steam.show');
Route::get('steam/user/{user}/reset', [App\Http\Controllers\SteamController::class, 'getNewGame'])->name('steam.getNewGame');

route::get('/steam/reviews', [App\Http\Controllers\SteamReviewController::class, 'all'])->name('steam.review.all');

route::get('/wiki', [App\Http\Controllers\WikiController::class, 'index'])->name('wiki.index');

Route::middleware('auth')->group(function () {
    route::get('/wiki/refresh', [App\Http\Controllers\WikiController::class, 'refreshPage'])->name('wiki.refresh');
    Route::resource('wiki', App\Http\Controllers\WikiController::class)->only(['store', 'show'])->middleware(HasValidHash::class);

    Route::resource('/wiki/challenge', App\Http\Controllers\WikiChallengesController::class)->only(['store', 'show']);
    Route::post('/wiki/challenge/{challenge}/start', [App\Http\Controllers\WikiChallengesController::class, 'start'])->name('challenge.start');

    Route::get('/music/lyrics', [App\Http\Controllers\LyricsController::class, 'index'])->name('lyrics');
    Route::get('/music/lastfm', [App\Http\Controllers\LastfmController::class, 'index'])->name('lastfm');
    Route::get('/music/lastfm/compare', [App\Http\Controllers\LastfmController::class, 'index'])->name('lastfm.compare');

    Route::post('steam/user/{user}/store', [App\Http\Controllers\SteamReviewController::class, 'store'])->name('steam.store');
    Route::patch('steam/user/{user}/update/{steamReview}', [App\Http\Controllers\SteamReviewController::class, 'update'])->name('steam.update');

    Route::resource('profile', App\Http\Controllers\ProfileController::class)->only(['edit', 'update', 'destroy']);

    route::get('/steam/reviews/{user}', [App\Http\Controllers\SteamReviewController::class, 'index'])->name('steam.review.index');
    route::get('/steam/reviews/{user}/review/{review}', [App\Http\Controllers\SteamReviewController::class, 'edit'])->name('steam.review.edit');


    Route::get('/spotify/auth', [App\Http\Controllers\Api\SpotifyController::class, 'authenticate'])->name('spotify.authenticate');
    Route::get('/spotify/callback', [App\Http\Controllers\Api\SpotifyController::class, 'callback'])->name('spotify.callback');
    Route::get('/spotify/following', [App\Http\Controllers\Api\SpotifyController::class, 'following'])->name('spotify.following');
    Route::get('/dashboard', [App\Http\Controllers\Api\SpotifyController::class, 'dashboard'])->name('spotify.dashboard');
    Route::get('/spotify/user', function (Request $request) {
        $api = new SpotifyWebAPI\SpotifyWebAPI();

        // Fetch the saved access token from somewhere. A session for example.
        $api->setAccessToken(session('spotify_access_token'));

        // It's now possible to request data about the currently authenticated user
//        session(['spotify_access_token' => $accessToken]);
        $user = $api->me();

            $playlists = $api->getUserPlaylists($user->id, [
                'limit' => 50
            ]);
//            dd(session('spotify_access_token'));
            dd($api->getMyCurrentTrack());
//            dd($api->getMyDevices());
//            dd(json_decode($api->getMyDevices()->devices[0]));
        $api->play('f00a2194a0862e524c5088bb1b03661be004935a', [
            'uris' => ['spotify:track:41hP8Zj09hdeQywGGIcXxA'],
        ]);
        dd(
            $playlists
        );

//        // Getting Spotify catalog data is of course also possible
//        print_r(
//            $api->getTrack('7EjyzZcbLxW7PaaLua9Ksb')
//        );
    });

    // Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
    // Route::post('/profile/destroy', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');

    //Route::post('/lastfmFetch', [App\Http\Controllers\LyricsController::class, 'fetch'])->name('Lastfm.fetch');
});
