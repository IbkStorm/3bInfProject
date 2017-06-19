<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use SpotifyWebAPI\Session;
use SpotifyWebAPI\SpotifyWebAPI;
class SpotifyController extends Controller
{
    public function SpotifyLogin(){
        /*return Socialite::with('spotify')
            ->redirect();*/
        $session = new Session(env('SPOTIFY_KEY'), env('SPOTIFY_SECRET'), env('SPOTIFY_REDIRECT_URI'));

        $options = [
            'scope' => [
                'playlist-read-private',
                'user-read-private',
            ],
        ];

        header('Location: ' . $session->getAuthorizeUrl($options));
        die();

    }

    public function SpotifyCallback(){

        $session = new Session(env('SPOTIFY_KEY'), env('SPOTIFY_SECRET'), env('SPOTIFY_REDIRECT_URI'));

// Request a access token using the code from Spotify
        $session->requestAccessToken($_GET['code']);
        $accessToken = $session->getAccessToken();
        $refreshToken = $session->getRefreshToken();

        session(['spotify_token' => $accessToken]);
        session(['spotify_refresh' => $refreshToken]);
        return redirect('/home');


    }
}
