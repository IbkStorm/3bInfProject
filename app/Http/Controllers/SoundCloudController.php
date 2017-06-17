<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;

class SoundCloudController extends Controller
{
   function SoundCloudLogin(){
       return Socialite::with('soundcloud')
           ->redirect();


       function SoundCloudCallback(){

           $user = Socialite::driver('soundcloud')->user();
           $accessTokenResponseBody = $user->accessTokenResponseBody;
           $accessToken = $user->token;
           $refreshToken = $accessTokenResponseBody->refresh_token;

           session(['spotify_token' => $accessToken]);
           session(['spotify_refresh' => $refreshToken]);
           return redirect('/');

       }
   }
}
