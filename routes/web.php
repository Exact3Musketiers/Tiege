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
    Route::get('/currency', [App\Http\Controllers\CurrencyController::class, 'index'])->name('currency');
    Route::get('/lyrics', [App\Http\Controllers\LyricsController::class, 'index'])->name('lyrics');


    Route::resource('random', App\Http\Controllers\RandomController::class);

    Route::post('/currencyFetch', [App\Http\Controllers\CurrencyController::class, 'fetch'])->name('Currency.fetch');
    //Route::post('/lastfmFetch', [App\Http\Controllers\LyricsController::class, 'fetch'])->name('Lastfm.fetch');
});
