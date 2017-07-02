<?php

namespace App\Http\Controllers;

use Google_Service_YouTube_Playlist;
use Google_Service_YouTube_PlaylistItem;
use Google_Service_YouTube_PlaylistItemSnippet;
use Google_Service_YouTube_PlaylistSnippet;
use Google_Service_YouTube_PlaylistStatus;
use Google_Service_YouTube_ResourceId;
use Illuminate\Http\Request;
use App\Spotify;
use App\YouTube;
use Alert;

class PlaylistConverterController extends Controller
{
    public function __construct(){
        ini_set('max_execution_time', 180);
    }


    public function YoutubeToSpotifyConvert($playlistID){

        try{
            $youtubevalue = session('youtube_token');
            $youtube = YouTube::make($youtubevalue);
            $list = $youtube->playlists->listPlaylists('snippet,contentDetails',
                array('id' => $playlistID));
            $youtubeplaylist_title = $list->items[0]->snippet->title;
                $youtubeplaylistItems = $youtube->playlistItems->listPlaylistItems('snippet,contentDetails', array('maxResults' => 50, 'playlistId' => $playlistID));
        }catch (\Exception $e){
            if ($e->getCode() == 0) {
                return redirect('youtube/login');
            } else {
                return dd($e);
            }
        }

        try{
            $value = session('spotify_token');
            $api = Spotify::make($value);
            $me = $api->me();
            $spotifyplaylist = $api->createUserPlaylist($me->id, ['name' => $youtubeplaylist_title]);
            foreach ($youtubeplaylistItems as $item) {
                $results = $api->search($item->snippet->title, 'track');
                try{
                    $api->addUserPlaylistTracks($me->id, $spotifyplaylist->id, $results->tracks->items[0]->id);
                }catch (\Exception $e) {
                }
            }
            Alert::success('Playlist erfolgreich konvertiert')->persistent('Schließen');
            return redirect('playlists');
        }catch (\Exception $e){
            return dd($e);
        }
    }

    public function SpotifyToYotubeConvert($userid, $playlistid){
        $count = 1;
        try {
            $value = session('spotify_token');
            $api = Spotify::make($value);
            $playlist = $api->getUserPlaylist($userid, $playlistid);
            $playlistTracks = $api->getUserPlaylistTracks($userid, $playlistid);
            //return dd($playlistTracks);
        } catch (\Exception $e) {
                return dd($e);
        }
        try {
            $youtubevalue = session('youtube_token');
            $youtube = YouTube::make($youtubevalue);
            $playlistId = $this->createYoutubePlaylist($playlist->name);

            foreach ($playlistTracks->items as $track) {
                $track = $track->track;
                $searchterm = $track->name.' '.$track->artists[0]->name;
                $search = $youtube->search->listSearch('snippet',
                    array('maxResults' => 1, 'q' => $searchterm, 'type' => 'video', 'videoCategoryId' => '10'));

                foreach ($search->items as $item){
                    $VideoID = $item->id->videoId;
                }
                $this->fillYoutubePlaylist($playlistId,$VideoID);
                $count ++;
            }
            Alert::success('Playlist erfolgreich konvertiert')->persistent('Schließen');
            return redirect('/playlists');

        } catch (\Exception $e) {
            if ($e->getCode() == 0) {
                return redirect('youtube/login');
            } else {
                return dd($e);
            }
        }
    }

    public function createYoutubePlaylist($Playlist_Title){

        try{
            $youtubevalue = session('youtube_token');
            $youtube = YouTube::make($youtubevalue);


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

    public function fillYoutubePlaylist($playlistId, $VideoID){

        $youtubevalue = session('youtube_token');
        $youtube = YouTube::make($youtubevalue);

        // 5. Add a video to the playlist. First, define the resource being added
        // to the playlist by setting its video ID and kind.
        $resourceId = new Google_Service_YouTube_ResourceId();
        $resourceId->setVideoId($VideoID);
        $resourceId->setKind('youtube#video');

        // Then define a snippet for the playlist item. Set the playlist item's
        // title if you want to display a different value than the title of the
        // video being added. Add the resource ID and the playlist ID retrieved
        // in step 4 to the snippet as well.
        $playlistItemSnippet = new Google_Service_YouTube_PlaylistItemSnippet();
        $playlistItemSnippet->setPlaylistId($playlistId);
        $playlistItemSnippet->setResourceId($resourceId);

        // Finally, create a playlistItem resource and add the snippet to the
        // resource, then call the playlistItems.insert method to add the playlist
        // item.
        $playlistItem = new Google_Service_YouTube_PlaylistItem();
        $playlistItem->setSnippet($playlistItemSnippet);
        $youtube->playlistItems->insert(
            'snippet,contentDetails', $playlistItem, array());

    }
}
