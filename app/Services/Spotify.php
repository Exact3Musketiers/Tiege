<?php

namespace App\Services;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;
use Illuminate\Support\Arr;
use SpotifyWebAPI;

class Spotify
{
    public static function Authenticate()
    {
        $session = new SpotifyWebAPI\Session(
            config('app.client_id'),
            config('app.client_secret'),
            config('app.redirect_uri'),
        );
        $state = $session->generateState();
        $options = [
            'scope' => [
                'playlist-read-private',
                'user-read-private',
                'streaming',
                'user-read-playback-state',
                'user-modify-playback-state',
                'user-follow-read',
                'user-top-read'
            ],
            'state' => $state,
        ];
        session(['spotify_state' => $state]);
        $session->getAuthorizeUrl($options);
//        dd($session->getAuthorizeUrl($options));
        return redirect()->away($session->getAuthorizeUrl($options));
    }

    public static function getToken($request)
    {
        $session = new SpotifyWebAPI\Session(
            config('app.client_id'),
            config('app.client_secret'),
            config('app.redirect_uri'),
        );

        $state = $request->get('state');

        // Fetch the stored state value from somewhere. A session for example
        if ($state !== session('spotify_state')) {
            // The state returned isn't the same as the one we've stored, we shouldn't continue
            die('State mismatch');
        }

        // Request a access token using the code from Spotify
        $session->requestAccessToken($request->get('code'));
//        dd($session);
        // Store the access and refresh tokens somewhere. In a session for example
        $accessToken = $session->getAccessToken();
        auth()->user()->update(['spotify_access_token' => Crypt::encryptString($accessToken)]);
        return;
    }

    public static function getFollowedArtists()
    {
        $api = new SpotifyWebAPI\SpotifyWebAPI();

        // Fetch the saved access token from somewhere. A session for example.
        $api->setAccessToken(session('spotify_access_token'));
        dd($api->getMyTop('tracks', [
            'limit' => 50,
            'offset' => 0,
            'time_range'=>'long_term'
        ]));
        dd($api->getArtist('2SmW1lFlBJn4IfBzBZDlSh'));
        return $api->getUserFollowedArtists([
            'limit' => 1,
            'after' => '0L8ExT028jH3ddEcZwqJJ5'
        ]);
    }

    public static function getTop($type = 'tracks',$limit = 50, $offset = 0, $time_range='short_term')
    {
        $api = new SpotifyWebAPI\SpotifyWebAPI();
        $api->setAccessToken(Crypt::decryptString(auth()->user()->spotify_access_token));

        return $api->getMyTop($type, [
            'limit' => $limit,
            'offset' => $offset,
            'time_range'=> $time_range
        ]);
    }
}
