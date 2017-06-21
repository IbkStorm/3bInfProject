<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google;
use SpotifyWebAPI\SpotifyWebAPI;

class PlaylistConverterController extends Controller
{
    public function YoutubeToSpotifyConvert(){

    }

    public function SpotifyToYotubeConvert($userid, $playlistid){
        $count = 1;
        try {
            $value = session('spotify_token');
            $api = new SpotifyWebAPI();
            $api->setAccessToken($value);
            $playlist = $api->getUserPlaylist($userid, $playlistid);
            $playlistTracks = $api->getUserPlaylistTracks($userid, $playlistid);
        } catch (\Exception $e) {
                return dd($e);
        }
        try {
            $googleClient = Google::getClient();
            $youtubevalue = session('youtube_token');
            $googleClient->setAccessToken($youtubevalue);
            $youtube = Google::make('Youtube');
            $new_playlist = $youtube->playlists->insert(array('snippet.title' => 'TEST'),
                'snippet,status');
            $new_playlist_id = $new_playlist->id;

            foreach ($playlistTracks->items as $track) {
                $track = $track->track;
                $search = $youtube->search->listSearch('snippet',
                    array('maxResults' => 25, 'q' => $track->name, 'type' => 'video', 'videoCategoryId' => '10'));

                $VideoID = $search->items[0]->videoId;

                $youtube->playlistItems->insert(array('snippet.playlistId' => $new_playlist_id,
                    'snippet.resourceId.kind' => 'youtube#video',
                    'snippet.resourceId.videoId' => $VideoID,
                    'snippet.position' => $count),
                    'snippet');
                $count ++;
            }

            return redirect('/palylists');

        } catch (\Exception $e) {
                return dd($e);
        }
    }
}
