<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google;

class YoutubeController extends Controller
{
    public function YoutubeLogin()
    {

        $googleClient = Google::getClient();
        $url = $googleClient->createAuthUrl();

        return redirect($url);

    }

    public function YoutubeCallback(){
        $googleClient = Google::getClient();
        $accessToken = $googleClient->fetchAccessTokenWithAuthCode($_GET['code']);

        session(['youtube_token' => $accessToken]);

        return redirect('/playlists');
    }

    public function YoutubeRefresh(){
        $googleClient = Google::getClient();
        if ($googleClient->isAccessTokenExpired()) {
            $refresh_token = $googleClient->getRefreshToken();

            $googleClient->fetchAccessTokenWithRefreshToken(session('youtube_token'));
            $access_token = $googleClient->getAccessToken();
            $access_token['refresh_token'] = $refresh_token;

            return dd($refresh_token);
            //session(['youtube_token' => $googleClient->getAccessToken()]);
        }
    }
}
