<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mockery\Exception;
use SpotifyWebAPI\SpotifyWebAPI;
use SpotifyWebAPI\Session;
use Google;

class PlaylistController extends Controller
{
    public function index()
    {
        $spotifyplaylists = '';
        $youtubeplaylists = '';
        if (session('spotify_token') != null) {
            try {
                $value = session('spotify_token');
                $api = new SpotifyWebAPI();
                $api->setAccessToken($value);
                $spotifyplaylists = $api->getMyPlaylists();

            } catch (\Exception $e) {
                if ($e->getCode() == 401) {
                    return redirect('spotify/refresh');
                } else {
                    return dd($e);

                }
            }

        }
        if (session('youtube_token') != null) {

            try {
                $googleClient = Google::getClient();
                $youtubevalue = session('youtube_token');
                $googleClient->setAccessToken($youtubevalue);
                $youtube = Google::make('Youtube');
                $youtubeplaylists = $youtube->playlists->listPlaylists('snippet,contentDetails', array('mine' => true));

            } catch (\Exception $e) {
                if ($e->getCode() == 0) {
                    return redirect('youtube/login');
                } else {
                    return dd($e);
                }
            }
        }
return view('playlist')->with(['spotifyplaylists' => $spotifyplaylists, 'youtubeplaylists' => $youtubeplaylists]);
}

public
function show($userid, $playlistid)
{
    try {
        $value = session('spotify_token');
        $api = new SpotifyWebAPI();
        $api->setAccessToken($value);
        $list = $api->getUserPlaylist($userid, $playlistid);
        dd($list);
    } catch (\Exception $e) {
        if ($e->getCode() == 401) {
            return redirect('spotify/refresh');
        } else {
            return dd($e);
        }
    }
}
}
