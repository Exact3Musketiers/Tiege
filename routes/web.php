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

Route::middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::post('/search', [App\Http\Controllers\HomeController::class, 'search'])->name('home.search');

    Route::get('/numbers/currency', [App\Http\Controllers\CurrencyController::class, 'index'])->name('currency');

    Route::get('/music/lyrics', [App\Http\Controllers\LyricsController::class, 'index'])->name('lyrics');
    Route::get('/music/lastfm', [App\Http\Controllers\LastfmController::class, 'index'])->name('lastfm');
    Route::get('/music/lastfm/compare', [App\Http\Controllers\LastfmController::class, 'index'])->name('lastfm.compare');

    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile');


    Route::resource('/numbers/random', App\Http\Controllers\RandomController::class);

    Route::post('/currencyFetch', [App\Http\Controllers\CurrencyController::class, 'fetch'])->name('currency.fetch');
    //Route::post('/lastfmFetch', [App\Http\Controllers\LyricsController::class, 'fetch'])->name('Lastfm.fetch');

    Route::get('/s', [App\Http\Controllers\SarcasmController::class, 'index'])->name('sarcasm');

});
