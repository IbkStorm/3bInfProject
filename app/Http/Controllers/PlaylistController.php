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
            return view('home')->with('playlists', $playpists);

        }catch(\Exception $e){
            return view('home');
        }
    }
    public function show($id){
        $value = session('spotify_token');
        $api = new SpotifyWebAPI();
        $api->setAccessToken($value);
        $me = $api->me();
        //$list = $api->getUserPlaylist($me->id,$id);
        return dd($me->id);
    }
}
