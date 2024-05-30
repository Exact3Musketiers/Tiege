<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/signIn', [App\Http\Controllers\Api\AuthController::class, 'signIn'])->name('signIn');
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/signOut', [App\Http\Controllers\Api\AuthController::class, 'signOut'])->name('signOut');
    //before axios call store the token and refresh token in db so that the app can use them when doing auth()->user()->token or something
    Route::get('/dashboard', [App\Http\Controllers\Api\SpotifyController::class, 'dashboard'])->name('spotify.dashboard');
});

