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
}
