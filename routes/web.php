<?php

use App\Http\Middleware\HasValidHash;
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
    
    Route::get('/music/lyrics', [App\Http\Controllers\LyricsController::class, 'index'])->name('lyrics');
    Route::get('/music/lastfm', [App\Http\Controllers\LastfmController::class, 'index'])->name('lastfm');
    Route::get('/music/lastfm/compare', [App\Http\Controllers\LastfmController::class, 'index'])->name('lastfm.compare');

    Route::post('steam/user/{user}/store', [App\Http\Controllers\SteamReviewController::class, 'store'])->name('steam.store');
    Route::patch('steam/user/{user}/update/{steamReview}', [App\Http\Controllers\SteamReviewController::class, 'update'])->name('steam.update');

    Route::resource('profile', App\Http\Controllers\ProfileController::class)->only(['edit', 'update', 'destroy']);

    route::get('/steam/reviews/{user}', [App\Http\Controllers\SteamReviewController::class, 'index'])->name('steam.review.index');
    route::get('/steam/reviews/{user}/review/{review}', [App\Http\Controllers\SteamReviewController::class, 'edit'])->name('steam.review.edit');



    // Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
    // Route::post('/profile/destroy', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');

    //Route::post('/lastfmFetch', [App\Http\Controllers\LyricsController::class, 'fetch'])->name('Lastfm.fetch');
});
