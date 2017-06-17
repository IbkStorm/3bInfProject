<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SpotifyWebAPI\SpotifyWebAPI;

class PlaylistController extends Controller
{
    public function index(){
        try{
            $value = session('spotify_token');
            $api = new SpotifyWebAPI();
            $api->setAccessToken($value);
           $playpists =$api->getMyPlaylists();
            return view('playlist')->with('spotifyplaylists', $playpists);

        }catch(\Exception $e){
            // catch code
        }
    }
}
