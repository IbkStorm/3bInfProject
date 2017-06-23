<?php

namespace App\Http\Controllers;

use Google_Service_YouTube_Playlist;
use Google_Service_YouTube_PlaylistSnippet;
use Google_Service_YouTube_PlaylistStatus;
use Illuminate\Http\Request;
use Google;
use SpotifyWebAPI\SpotifyWebAPI;

class PlaylistConverterController extends Controller
{
    public function YoutubeToSpotifyConvert($playlistID){

        try{
            $googleClient = Google::getClient();
            $youtubevalue = session('youtube_token');
            $googleClient->setAccessToken($youtubevalue);
            $youtube = Google::make('Youtube');
            $list =$youtube->playlists->listPlaylists('snippet,contentDetails',
                array('id' => $playlistID));

            dd($list);
        }catch (\Exception $e){
            if ($e->getCode() == 0) {
                return redirect('youtube/login');
            } else {
                return dd($e);
            }
        }
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
            $new_playlist_id = $this->createPlaylist($playlist->name);

            foreach ($playlistTracks->items as $track) {
                $track = $track->track;
                $search = $youtube->search->listSearch('snippet',
                    array('maxResults' => 1, 'q' => $track->name, 'type' => 'video', 'videoCategoryId' => '10'));

                foreach ($search->items as $item){
                    $VideoID = $item->id->videoId;
                }

                $youtube->playlistItems->insert(array('snippet.playlistId' => $new_playlist_id,
                    'snippet.resourceId.kind' => 'youtube#video',
                    'snippet.resourceId.videoId' => $VideoID,
                    'snippet.position' => $count),
                    'snippet');
                $count ++;
            }

            return redirect('/palylists');

        } catch (\Exception $e) {
            if ($e->getCode() == 0) {
                return redirect('youtube/login');
            } else {
                return dd($e);
            }
        }
    }

    public function createPlaylist($Playlist_Title){

        try{
            $googleClient = Google::getClient();
            $youtubevalue = session('youtube_token');
            $googleClient->setAccessToken($youtubevalue);
            $youtube = Google::make('Youtube');


            // 1. Create the snippet for the playlist. Set its title and description.
            $playlistSnippet = new Google_Service_YouTube_PlaylistSnippet();
            $playlistSnippet->setTitle($Playlist_Title);
            //$playlistSnippet->setDescription('A private playlist created with the YouTube API v3');

            // 2. Define the playlist's status.
            $playlistStatus = new Google_Service_YouTube_PlaylistStatus();
            $playlistStatus->setPrivacyStatus('private');

            // 3. Define a playlist resource and associate the snippet and status
            // defined above with that resource.
            $youTubePlaylist = new Google_Service_YouTube_Playlist();
            $youTubePlaylist->setSnippet($playlistSnippet);
            $youTubePlaylist->setStatus($playlistStatus);

            // 4. Call the playlists.insert method to create the playlist. The API
            // response will contain information about the new playlist.
            $playlistResponse = $youtube->playlists->insert('snippet,status',
                $youTubePlaylist, array());
            $playlistId = $playlistResponse['id'];
            return $playlistId;
        }catch (\Exception $e) {
            return dd($e);
        }
    }
}
