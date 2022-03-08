<?php

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


Route::resource('/numbers/random', App\Http\Controllers\RandomController::class);

Route::post('/currencyFetch', [App\Http\Controllers\CurrencyController::class, 'fetch'])->name('currency.fetch');

Route::get('/s', [App\Http\Controllers\SarcasmController::class, 'index'])->name('sarcasm');
Route::get('/UwU', [App\Http\Controllers\PagesController::class, 'uwu'])->name('uwu');

Route::middleware('auth')->group(function () {
    Route::get('/music/lyrics', [App\Http\Controllers\LyricsController::class, 'index'])->name('lyrics');
    Route::get('/music/lastfm', [App\Http\Controllers\LastfmController::class, 'index'])->name('lastfm');
    Route::get('/music/lastfm/compare', [App\Http\Controllers\LastfmController::class, 'index'])->name('lastfm.compare');
    Route::get('/user/{user}/steam', [App\Http\Controllers\SteamController::class, 'show'])->name('steam.show');
    Route::get('/user/{user}/steam/reset', [App\Http\Controllers\SteamController::class, 'getNewGame'])->name('steam.getNewGame');

    Route::resource('profile', App\Http\Controllers\ProfileController::class)->only(['edit', 'update', 'destroy']);


    // Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
    // Route::post('/profile/destroy', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');

    //Route::post('/lastfmFetch', [App\Http\Controllers\LyricsController::class, 'fetch'])->name('Lastfm.fetch');
});
